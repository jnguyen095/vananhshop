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
}
