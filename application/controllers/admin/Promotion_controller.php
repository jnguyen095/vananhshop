<?php

class Promotion_controller extends MY_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->library('session');
        $this->load->model('Promotion_Model');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('pagination');
        $this->load->helper('bootstrap_pagination_admin');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $crudaction = $this->input->post('crudaction');
        if ($crudaction == 'delete-multiple') {
            $promotionIds = $this->input->post('checkList');
            if ($promotionIds != null && is_array($promotionIds)) {
                foreach ($promotionIds as $promotionId) {
                    $this->Promotion_Model->deletePromotionById($promotionId);
                }
                $data['message_response'] = 'Xóa khuyến mãi thành công.';
            }
        }

        $config = pagination($this);
        $config['base_url'] = base_url('admin/promotion/list.html');
        if (!$config['orderField']) {
            $config['orderField'] = 'StartDate';
            $config['orderDirection'] = 'DESC';
        }

        $searchFor = $this->input->get('query');
        $type = $this->input->get('type');
        $status = $this->input->get('status');

        $results = $this->Promotion_Model->searchByProperties($config['page'], $config['per_page'], $searchFor, $type, $status, $config['orderField'], $config['orderDirection']);
        $data['promotions'] = $results['items'];
        $config['total_rows'] = $results['total'];
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['message_response'] = isset($data['message_response']) ? $data['message_response'] : null;
        $data['types'] = $this->Promotion_Model->getPromotionTypes();
        $data['conditionTypes'] = $this->Promotion_Model->getConditionTypes();

        $this->load->view('admin/promotion/list', $data);
    }

    public function edit($promotionId = null)
    {
        if ($promotionId == null) {
            $promotionId = $this->input->post('PromotionsID');
        }

        $data['promotionTypes'] = $this->Promotion_Model->getPromotionTypes();
        $data['conditionTypes'] = $this->Promotion_Model->getConditionTypes();
        $data['promotion'] = null;
        $data['conditions'] = [];

        if ($this->input->post('crudaction') == 'insert') {
            $this->form_validation->set_rules('Name', 'Tên khuyến mãi', 'trim|required');
            $this->form_validation->set_rules('Type', 'Loại khuyến mãi', 'trim|required');
            $this->form_validation->set_rules('DiscountValue', 'Giá trị giảm', 'trim|required|numeric');
            $this->form_validation->set_rules('DiscountType', 'Loại giảm giá', 'trim|required');

            $promotion = array(
                'PromotionsID' => $promotionId,
                'Name' => $this->input->post('Name'),
                'Description' => $this->input->post('Description'),
                'Type' => $this->input->post('Type'),
                'DiscountValue' => $this->input->post('DiscountValue'),
                'DiscountType' => $this->input->post('DiscountType'),
                'StartDate' => $this->parseDate($this->input->post('StartDate')),
                'EndDate' => $this->parseDate($this->input->post('EndDate')),
                'Active' => $this->input->post('Active') == 1 ? 1 : 0,
            );

            $conditionTypes = $this->input->post('ConditionType');
            $conditionValues = $this->input->post('ConditionValue');
            $conditions = [];
            if (is_array($conditionTypes) && is_array($conditionValues)) {
                foreach ($conditionTypes as $index => $conditionType) {

                    $conditionValue = isset($conditionValues[$index]) ? $conditionValues[$index] : null;
                    if ($conditionType && strlen(trim($conditionValue)) > 0) {
                        $conditions[] = array(
                            'ConditionType' => $conditionType,
                            'ConditionValue' => $conditionValue,
                        );
                    }
                }
            }

            if ($this->form_validation->run() == FALSE) {
                $data['message_response'] = 'Dữ liệu chưa đúng, kiểm tra lại.';
                $data['promotion'] = (object)$promotion;
                $data['conditions'] = $conditions;
            } else {
               $promotionId = $this->Promotion_Model->savePromotion($promotion);
               $this->Promotion_Model->saveConditions($promotionId, $conditions);
               redirect('admin/promotion/list');
            }
        } else if ($promotionId != null) {
            $data['promotion'] = $this->Promotion_Model->findById($promotionId);
            $data['conditions'] = $this->Promotion_Model->findConditionsByPromotionId($promotionId);
        }

        $this->load->view('admin/promotion/edit', $data);
    }

    private function parseDate($dateString)
    {
        if (empty($dateString)) {
            return null;
        }
        $dateString = str_replace('/', '-', $dateString);
        $timestamp = strtotime($dateString);
        return $timestamp ? date('Y-m-d H:i:s', $timestamp) : null;
    }
}
