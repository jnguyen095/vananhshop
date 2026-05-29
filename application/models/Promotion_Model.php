<?php

class Promotion_Model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function searchByProperties($start, $limit, $searchFor, $type, $status, $orderField, $orderDirection)
    {
        $this->db->start_cache();
        $this->db->select('p.*, (SELECT COUNT(*) FROM PromotionCondition pc WHERE pc.PromotionID = p.PromotionsID) AS ConditionCount');
        $this->db->from('promotion p');

        if (!empty($searchFor)) {
            $this->db->like('p.Name', $searchFor);
        }
        if (!empty($type)) {
            $this->db->where('p.Type', $type);
        }
        if ($status !== null && $status !== '' && $status != '-1') {
            $this->db->where('p.Active', $status);
        }

        $this->db->stop_cache();

        $total = $this->db->count_all_results();

        if (!empty($orderField)) {
            $this->db->order_by($orderField, $orderDirection);
        }
        $query = $this->db->get(null, $limit, $start);
        $items = $query->result();

        $this->db->flush_cache();

        return array('items' => $items, 'total' => $total);
    }

    public function findById($promotionId)
    {
        $this->db->where('PromotionsID', $promotionId);
        $query = $this->db->get('promotion');
        return $query->row();
    }

    public function findConditionsByPromotionId($promotionId)
    {
        $this->db->where('PromotionID', $promotionId);
        $this->db->order_by('PromotionConditionID', 'ASC');
        $query = $this->db->get('PromotionCondition');
        return $query->result();
    }

    public function savePromotion($data)
    {
        $newData = array(
            'Name' => $data['Name'],
            'Description' => $data['Description'],
            'Type' => $data['Type'],
            'DiscountValue' => $data['DiscountValue'],
            'DiscountType' => $data['DiscountType'],
            'StartDate' => $data['StartDate'],
            'EndDate' => $data['EndDate'],
            'Active' => isset($data['Active']) ? $data['Active'] : 0,
        );

        if (isset($data['PromotionsID']) && $data['PromotionsID'] > 0) {
            $this->db->where('PromotionsID', $data['PromotionsID']);
            $this->db->update('promotion', $newData);
            return $data['PromotionsID'];
        }

        $this->db->insert('promotion', $newData);
        return $this->db->insert_id();
    }

    public function saveConditions($promotionId, $conditions)
    {
        $this->db->where('PromotionID', $promotionId);
        $this->db->delete('PromotionCondition');

        if (is_array($conditions)) {
            foreach ($conditions as $condition) {
                $insert = array(
                    'PromotionID' => $promotionId,
                    'ConditionType' => $condition['ConditionType'],
                    'ConditionValue' => $condition['ConditionValue'],
                );
                $this->db->insert('PromotionCondition', $insert);
            }
        }
    }

    public function deletePromotionById($promotionId)
    {
        $this->db->where('PromotionsID', $promotionId);
        $this->db->delete('promotion');
    }

    public function getPromotionTypes()
    {
        return array(
            'order_discount' => 'Giảm giá đơn hàng',
            'shipping_discount' => 'Giảm phí vận chuyển',
            'category_discount' => 'Giảm theo danh mục',
            'first_order_discount' => 'Giảm đơn hàng đầu tiên'
        );
    }

    public function getConditionTypes()
    {
        return array(
            'min_order_value' => 'Giá trị đơn hàng tối thiểu',
            'first_order' => 'Đơn hàng đầu tiên',
            'category' => 'Danh mục',
            'product' => 'Sản phẩm',
            'shipping' => 'Hình thức vận chuyển',
			'promotion_code' => 'Nhập mã khuyến mãi'
        );
    }

    public function findByPromotionCode($proCode)
    {
        $this->db->where('Name', $proCode);
        $this->db->where('Active', 1);
        $this->db->where('(StartDate IS NULL OR StartDate <= NOW())', null, false);
        $this->db->where('(EndDate IS NULL OR EndDate >= NOW())', null, false);
        $query = $this->db->get('promotion');
        return $query->row();
    }

    public function findPromotionConditionByCode($proCode){
    	$sql = "select pc.* from PromotionCondition pc inner join promotion p on pc.PromotionID = p.PromotionsID";
		$sql .= " where pc.ConditionValue = '" . $proCode . "' and pc.ConditionType = 'promotion_code'";
		$sql .= " and p.Active = 1 and (p.StartDate is null or p.StartDate <= NOW()) and (p.EndDate is null or p.EndDate >= NOW())";
    	$query = $this->db->query($sql);
    	return $query->row();
	}

    public function validatePromotion($proCode, $cartTotal = 0, $userId = null)
    {
        //$promotion = $this->findByPromotionCode($proCode);
		$condition = $this->findPromotionConditionByCode($proCode);
		if(!$condition){
			return array(
				'valid' => false,
				'message' => 'Mã khuyến mãi không tồn tại hoặc đã hết hạn.'
			);
		}
		$promotion = $this->findById($condition->PromotionID);
		/*
        $conditions = $this->findConditionsByPromotionId($promotion->PromotionsID);
        
        foreach ($conditions as $condition) {
            if ($condition->ConditionType == 'min_order_value') {
                $minValue = (float)$condition->ConditionValue;
                if ($cartTotal < $minValue) {
                    return array(
                        'valid' => false,
                        'message' => 'Đơn hàng tối thiểu phải từ ' . number_format($minValue) . ' đ'
                    );
                }
            } elseif ($condition->ConditionType == 'first_order') {
                if ($userId) {
                    $this->db->where('CreatedBy', $userId);
                    $orderCount = $this->db->count_all_results('myorder');
                    if ($orderCount > 0) {
                        return array(
                            'valid' => false,
                            'message' => 'Mã khuyến mãi chỉ áp dụng cho đơn hàng đầu tiên.'
                        );
                    }
                }
            }
        }*/

        return array(
            'valid' => true,
            'promotion' => $promotion
        );
    }

    public function calculateDiscount($promotion, $cartTotal = 0, $shippingFee = 0)
    {
        if (!$promotion) {
            return 0;
        }

        $discountAmount = 0;
        $totalWithShipping = $cartTotal + $shippingFee;

        if ($promotion->Type == 'order_discount') {
            if ($promotion->DiscountType == 'percentage') {
                $discountAmount = ($cartTotal * $promotion->DiscountValue) / 100;
            } else {
                $discountAmount = $promotion->DiscountValue;
            }
            $discountAmount = min($discountAmount, $cartTotal);
        } elseif ($promotion->Type == 'shipping_discount') {
            if ($promotion->DiscountType == 'percentage') {
                $discountAmount = ($shippingFee * $promotion->DiscountValue) / 100;
            } else {
                $discountAmount = $promotion->DiscountValue;
            }
            $discountAmount = min($discountAmount, $shippingFee);
        } elseif ($promotion->Type == 'first_order_discount') {
            if ($promotion->DiscountType == 'percentage') {
                $discountAmount = ($totalWithShipping * $promotion->DiscountValue) / 100;
            } else {
                $discountAmount = $promotion->DiscountValue;
            }
            $discountAmount = min($discountAmount, $totalWithShipping);
        }

        return max(0, $discountAmount);
    }

    public function recordPromotionApplication($promotionId, $orderId, $discountAmount)
    {
        if (!$promotionId || !$orderId || $discountAmount <= 0) {
            return false;
        }

        $data = array(
            'PromotionID' => $promotionId,
            'OrderID' => $orderId,
            'DiscountAmount' => $discountAmount,
            'AppliedAt' => date('Y-m-d H:i:s')
        );

        $this->db->insert('PromotionApplication', $data);
        return $this->db->insert_id();
    }
}
