<?php

/**
 * Created by Khang Nguyen.
 * Email: nguyennhukhangvn@gmail.com
 * Date: 7/20/2017
 * Time: 3:42 PM
 */
class Product_Model extends CI_Model
{
	function __construct() {
		parent::__construct();
	}

	public function findById($productId) {
		$this->db->where(array("ProductID" => $productId));
		$query = $this->db->get("product");
		$product = $query->row();
		return $product;
	}

	public function findPostWithPackageToday($ipAddress, $phoneNumber, $package){
		// $this->output->enable_profiler(TRUE);
		$this->db->where(array("IpAddress" => $ipAddress, "date(PostDate)" => date('Y-m-d'), "Vip" => $package));
		$totalByIps = $this->db->count_all_results('product');
		$totalByPhone = 0;
		if($phoneNumber != null && count($phoneNumber) > 0){
			$sql = 'select count(*) as Total from product p inner join productdetail pd on p.productid = pd.productid';
			$sql .= " where p.vip = {$package} and date(p.postdate) = date(now()) and pd.contactphone = {$phoneNumber}";
			$query = $this->db->query($sql);
			$row = $query->row();
			$totalByPhone = $row->Total;
		}
		return $totalByIps > $totalByPhone ? $totalByIps : $totalByPhone;
	}

	public function isValidPost($loginId, $ipAddress, $phoneNumber){
		// Check in User table with StandardPost
		// $this->output->enable_profiler(TRUE);
		$this->db->select("StandardPost");
		$this->db->where(array("Us3rID" => $loginId));
		$totalPost = (int)$this->db->get("us3r")->row()->StandardPost;
		if($totalPost >= MAX_FREE_POST){
			return false;
		}else{
			// Check in Product table with IpAddress
			$this->db->where(array("IpAddress" => $ipAddress, "Vip" => PRODUCT_STANDARD));
			$totalByIps = $this->db->count_all_results('product');
			if($totalByIps >= MAX_FREE_POST){
				return false;
			}else{
				// Check in Product table with contactPhong
				if($phoneNumber != null && count($phoneNumber) > 0){
					$standardPostVip = PRODUCT_STANDARD;
					$sql = 'select count(*) as Total from product p inner join productdetail pd on p.productid = pd.productid';
					$sql .= " where p.vip = {$standardPostVip} and pd.contactphone = {$phoneNumber}";
					$query = $this->db->query($sql);
					$row = $query->row();
					$totalByPhone = $row->Total;
					if($totalByPhone >= MAX_FREE_POST){
						return false;
					}
				}

			}
		}
		return true;
	}

	public function findByUserId($userId, $page) {
		/*$this->db->order_by('ModifiedDate', 'desc');
		$this->db->where(array("CreatedByID" => $userId));

		$query = $this->db->get("product", 10, $page);
		$data['products'] = $query->result();
		*/
		$query = $this->db->select('p.*, pc.Money, pc.Reason')
			->from('product p')
			->join('purchasehistory pc', 'p.ProductID = pc.ProductID', 'left')
			->where('p.CreatedByID', $userId)
			->limit(10, $page)
			->order_by("ModifiedDate", "desc")
			->get();
		$data['products'] = $query->result();

		$this->db->where(array("CreatedByID" => $userId));
		$total = $this->db->count_all_results('product');
		$data['total'] = $total;
		return $data;
	}

	public function findByCategoryCode($catCode, $offset, $limit) {
		$sql = 'select p.*, c.cityname as city, d.districtname as district from product p';
		$sql .= ' inner join city c on p.cityid = c.cityid';
		$sql .= ' inner join district d on p.districtid = d.districtid';
		$sql .= ' inner join category ct on ct.categoryid = p.categoryid';
		$sql .= ' where ct.parentid in(select ct1.categoryid from category ct1 where (ct1.code = \''.$catCode.'\' or ct.code = \''.$catCode.'\')) and p.status = '.ACTIVE;
		$sql .= ' order by date(p.modifieddate) desc, p.vip asc';
		$sql .= ' limit '.$offset.','.$limit;
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function findByHotProduct(){
		$sql = 'select p.ProductID as ProductID, p.Title as Title, p.Brief as Brief, p.Thumb as Thumb, p.PriceString as PriceString, p.Area as Area, c.CityName as CityName, d.DistrictName as DistrictName from product p';
		$sql .= ' inner join city c on p.CityID = c.CityID';
		$sql .= ' inner join district d on d.DistrictID = p.DistrictID';
		$sql .= ' where p.HotProduct = ' . ACTIVE;
		$products = $this->db->query($sql)->result();
		return $products;
	}

	public function updateViewForProductId($productId){
		$this->db->set('View', 'View + 1', false);
		$this->db->where('ProductID', $productId);
		$this->db->where('Status', ACTIVE);
		$this->db->update('product');
	}

	public function updateViewForProductIdManual($productId, $view){
		$this->db->set('View', $view);
		$this->db->where('ProductID', $productId);
		$this->db->update('product');
	}

	public function updateVipPackageForProductId($productId, $vip){
		$this->db->set('Vip', $vip);
		$this->db->where('ProductID', $productId);
		$this->db->update('product');
	}

	public function pushPostUp($productId){
		$this->db->set('ModifiedDate', 'NOW()', false);
		$this->db->set('RefreshCount', 'RefreshCount + 1', false);
		$this->db->where('ProductID', $productId);
		$this->db->update('product');
	}

	public function countProductWithUser($userId){
		$sql = "select count(*) as Total from product p where p.status = 1 and p.CreatedByID = {$userId}";
		$query = $this->db->query($sql);
		$row = $query->row();
		return $row->Total;
	}

	public function checkNewProductIsValid($product){
		$sql = "select count(*) as Total from product p where p.CategoryID = {$product['CategoryID']} and p.Title = '{$product['Title']}'";
		if($product['ProductID'] != null & $product['ProductID'] > 0){
			$sql .= " and p.ProductID <> {$product['ProductID']}";
		}
		$query = $this->db->query($sql);
		$row = $query->row();
		return $row->Total;
	}

	public function findByIdFetchAll($productId) {
		$sql = 'select * from product p inner join productdetail pd on p.productid = pd.productid';
		$sql .= ' where p.ProductID = '. $productId;
		$query = $this->db->query($sql);
		$product = $query->row();

		// Fetch Brand
		if($product != null) {
			/*if ($product->BrandID != null) {
				$this->db->where("BrandID", $product->BrandID);
				$query = $this->db->get("brand");
				$product->Brand = $query->row();
			}

			// Fetch City
			if ($product->CityID != null) {
				$this->db->where("CityID", $product->CityID);
				$query = $this->db->get("city");
				$product->City = $query->row();
			}

			// Fetch District
			if ($product->DistrictID != null) {
				$this->db->where("DistrictID", $product->DistrictID);
				$query = $this->db->get("district");
				$product->District = $query->row();
			}

			// Fetch Ward
			if ($product->WardID != null) {
				$this->db->where("WardID", $product->WardID);
				$query = $this->db->get("ward");
				$product->Ward = $query->row();
			}

			// Fetch Ward
			if ($product->UnitID != null) {
				$this->db->where("UnitID", $product->UnitID);
				$query = $this->db->get("unit");
				$product->Unit = $query->row();
			}

			// Fetch Direction
			if ($product->DirectionID != null) {
				$this->db->where("DirectionID", $product->DirectionID);
				$query = $this->db->get("direction");
				$product->Direction = $query->row();
			}
			*/
			// Product Assets
			$this->db->where("ProductID", $productId);
			$query = $this->db->get("productasset");
			$product->Assets = $query->result();
		}
		return $product;
	}

	public function findByDetailId($productId) {
		$sql = 'select * from product p';
		$sql .= ' where p.ProductID = '. $productId;
		$query = $this->db->query($sql);
		$product = $query->row();

		// Fetch Brand
		if($product != null) {
			// Product Assets
			$this->db->where("ProductID", $productId);
			$query = $this->db->get("productasset");
			$product->Assets = $query->result();

			// Product Properties
			$sql = 'select P0.ProductPropertyID, P0.PropertyName, P1.PropertyID as \'ParentID\', P1.PropertyName as \'ParentName\' from(select pp.ProductPropertyID, p.PropertyName, p.PropertyID, p.ParentID from productproperty pp inner join property p ON pp.PropertyID = p.PropertyID where pp.ProductID = '.$productId.') as P0 INNER join property P1 on P0.ParentID = P1.PropertyID';

			$query = $this->db->query($sql);
			$properties = $query->result();
			$propertyKeyVal = [];
			foreach ($properties as $property){
				// print_r($property);
				if(!isset($propertyKeyVal[$property->ParentName])){
					$propertyKeyVal[$property->ParentName] = [];
				}
				$propertyKeyVal[$property->ParentName][$property->ProductPropertyID]['ParentID'] = $property->ParentID;
				$propertyKeyVal[$property->ParentName][$property->ProductPropertyID]['ProductPropertyID'] = $property->ProductPropertyID;
				$propertyKeyVal[$property->ParentName][$property->ProductPropertyID]['Name'] = $property->PropertyName;

			}
			//print_r($propertyKeyVal);
			$product->Properties = $propertyKeyVal;
		}
		return $product;
	}

	public function findByCatId($catId, $start=null, $limit=null){
		$query = $this->db->order_by('PostDate', 'desc')->get_where('product', array('CategoryID' => $catId, "Status" => 1), $limit, $start);
		$products = $query->result();

		$this->db->where('CategoryID', $catId);
		$total = $this->db->count_all_results('product');

		$data['products'] = $products;
		$data['total'] = $total;
		return $data;
	}

	public function findByCityIdFetchAddress($cityId, $offset, $limit){
		$sql = 'select p.*, c.cityname as city, d.districtname as district from product p';
		$sql .= ' inner join city c on p.cityid = c.cityid';
		$sql .= ' inner join district d on p.districtid = d.districtid';
		$sql .= ' where p.CityID = '.$cityId.' and p.status = 1';
		$sql .= ' order by date(p.modifieddate) desc, p.vip asc';
		$sql .= ' limit '.$offset.','.$limit;

		$countsql = 'select count(*) as total from product where CityID = '.$cityId.' and Status = 1';

		$products = $this->db->query($sql);
		$total = $this->db->query($countsql);

		$data['products'] = $products->result();
		$total = $total->row();
		$data['total'] = $total->total;
		return $data;
	}

	public function findByDistrictIdFetchAddress($districtId, $offset, $limit){
		$sql = 'select p.*, c.cityname as city, d.districtname as district from product p';
		$sql .= ' inner join city c on p.cityid = c.cityid';
		$sql .= ' inner join district d on p.districtid = d.districtid';
		$sql .= ' where p.DistrictID = '.$districtId.' and p.status = 1';
		$sql .= ' order by date(p.modifieddate) desc, p.vip asc';
		$sql .= ' limit '.$offset.','.$limit;

		$countsql = 'select count(*) as total from product where DistrictID = '.$districtId.' and Status = 1';

		$products = $this->db->query($sql);
		$total = $this->db->query($countsql);

		$data['products'] = $products->result();
		$total = $total->row();
		$data['total'] = $total->total;
		return $data;
	}

	public function findByBranchIdFetchAddress($branchId, $offset, $limit){
		$sql = 'select p.*, c.cityname as city, d.districtname as district from product p';
		$sql .= ' inner join city c on p.cityid = c.cityid';
		$sql .= ' inner join district d on p.districtid = d.districtid';
		$sql .= ' where p.BrandID = '.$branchId.' and p.status = 1';
		$sql .= ' order by date(p.modifieddate) desc, p.vip asc';
		$sql .= ' limit '.$offset.','.$limit;

		$countsql = 'select count(*) as total from product where BrandID = '.$branchId.' and Status = 1';

		$products = $this->db->query($sql);
		$total = $this->db->query($countsql);

		$data['products'] = $products->result();
		$total = $total->row();
		$data['total'] = $total->total;
		return $data;
	}

	public function findByCatIdAndCityIdFetchAddress($catId, $cityId, $offset, $limit){
		$sql = 'select p.*, c.cityname as city, d.districtname as district from product p';
		$sql .= ' inner join city c on p.cityid = c.cityid';
		$sql .= ' inner join district d on p.districtid = d.districtid';
		$sql .= ' where p.CategoryID = '.$catId.' and p.CityID = '.$cityId.' and p.status = 1';
		$sql .= ' order by date(p.modifieddate) desc, p.vip asc';
		$sql .= ' limit '.$offset.','.$limit;

		$countsql = 'select count(*) as total from product where CategoryID = '.$catId.' and CityID = '.$cityId.' and Status = 1';

		$products = $this->db->query($sql);
		$total = $this->db->query($countsql);

		$data['products'] = $products->result();
		$total = $total->row();
		$data['total'] = $total->total;
		return $data;
	}

	public function findByCatIdAndDistrictIdFetchAddressNotCurrent($catId, $districtId, $limit, $currentProductId){
		$sql = 'select p.*, c.cityname as city, d.districtname as district from product p';
		$sql .= ' inner join city c on p.cityid = c.cityid';
		$sql .= ' inner join district d on p.districtid = d.districtid';
		$sql .= ' where p.CategoryID = '.$catId.' and p.DistrictID = '.$districtId.' and p.status = '.ACTIVE;
		$sql .= ' and p.ProductID not in('.$currentProductId.')';
		$sql .= ' order by date(p.modifieddate) desc, p.vip asc';
		$sql .= ' limit 0, '.$limit;
		$products = $this->db->query($sql);
		return $products->result();
	}

	public function findByCatIdAndCityIdFetchAddressNotCurrent($catId, $cityId, $limit, $currentProductId){
		$sql = 'select p.*, c.cityname as city, d.districtname as district from product p';
		$sql .= ' inner join city c on p.cityid = c.cityid';
		$sql .= ' inner join district d on p.districtid = d.districtid';
		$sql .= ' where p.CategoryID = '.$catId.' and p.CityID = '.$cityId.' and p.status = '.ACTIVE;
		$sql .= ' and p.ProductID not in('.$currentProductId.')';
		$sql .= ' order by date(p.modifieddate) desc, p.vip asc';
		$sql .= ' limit 0, '.$limit;
		$products = $this->db->query($sql);
		return $products->result();
	}

	public function findByCatIdFetchAddress($catId, $offset, $limit){
		//$this->output->enable_profiler(TRUE);
		$sql = 'select p.* from product p';
		$sql .= ' where p.categoryid = '.$catId.' and p.status = 1';
		$sql .= ' order by date(p.modifieddate) desc';
		$sql .= ' limit '.$offset.','.$limit;

		$countsql = 'select count(*) as total from product where CategoryID = '.$catId.' and Status = 1';

		$products = $this->db->query($sql);
		$total = $this->db->query($countsql);

		$data['products'] = $products->result();
		$total = $total->row();
		$data['total'] = $total->total;
		return $data;
	}

	public function findByCatIdFetchChildren($catId, $offset, $limit){
		//$this->output->enable_profiler(TRUE);
		$sql = 'select p.* from product p';
		$sql .= ' where p.status = 1 and (p.categoryid = '.$catId.' or p.categoryid in (select c.CategoryID from category c where c.Active = 1 AND c.ParentID = '.$catId.' ))';
		$sql .= ' order by date(p.modifieddate) desc';
		$sql .= ' limit '.$offset.','.$limit;

		$countsql = 'select count(*) as total from product where Status = 1 and (CategoryID = '.$catId.' or CategoryID in (select c.CategoryID from category c where c.Active = 1 AND c.ParentID = '.$catId.' ))';

		$products = $this->db->query($sql);
		$total = $this->db->query($countsql);

		$data['products'] = $products->result();
		$total = $total->row();
		$data['total'] = $total->total;
		return $data;
	}

	public function findByCatIdAndDistrictId($catId, $districtId, $offset, $limit){
		// $this->output->enable_profiler(TRUE);
		$sql = 'select p.*, c.cityname as city, d.districtname as district from product p';
		$sql .= ' inner join city c on p.cityid = c.cityid';
		$sql .= ' inner join district d on p.districtid = d.districtid';
		$sql .= ' where p.CategoryID = '.$catId.' and p.DistrictID = '.$districtId.' and p.status = '.ACTIVE;
		$sql .= ' order by date(p.modifieddate) desc, p.vip asc';
		$sql .= ' limit '.$offset. ','.$limit;

		$countsql = 'select count(*) as total from product p';
		$countsql .= ' inner join city c on p.cityid = c.cityid';
		$countsql .= ' inner join district d on p.districtid = d.districtid';
		$countsql .= ' where p.CategoryID = '.$catId.' and p.DistrictID = '.$districtId.' and p.status = '.ACTIVE;

		$products = $this->db->query($sql);
		$total = $this->db->query($countsql);

		$data['products'] = $products->result();
		$total = $total->row();
		$data['total'] = $total->total;
		return $data;
	}

	public function updatePost($data, $assets){
		$productId = $data['productId'];

		// Get Unit
		$this->db->where("UnitID", $data['unit']);
		$query = $this->db->get("unit");
		$unit = $query->row();

		$updateData = array(
			'Title' => $data['title'],
			'Brief' => strip_tags(substr($data['description'], 0, 400).'...'),
			'Price' => $data['price'],
			'PriceString' => ($data['price'] != null && $data['price'] > 0) ? $data['price'].' '.$unit->Title : "Thỏa thuận",
			'Area' => ($data['area'] != null && $data['area'] > 0) ? $data['area'].' m²' : "KXĐ",
			'ModifiedDate' => date('Y-m-d H:i:s'),
			'CityID' => $data['city'],
			'DistrictID' => $data['district'],
			'WardID' => $data['ward'],
			'Street' => $data['street'],
			'CategoryID' => $data['categoryID'],
			// 'Status' => ACTIVE,
			'UnitID' => $data['unit'],
			'Address' => $data['address']
		);

		$newdatadetail = array(
			'Detail' => $data['description'],
			'Floor' => $data['floor'],
			'Room' => $data['room'],
			'Toilet' => $data['toilet'],
			'WidthSize' => $data['width'],
			'LongSize' => $data['long'],
			'Longitude' => $data['longitude'],
			'Latitude' => $data['latitude'],
			'ContactPhone' => $data['contact_phone'],
			'ContactAddress' => $data['contact_address'],
			'ContactEmail' => $data['txt_email'],
			'ContactName' => $data['contact_name'],
			'Source' => null
		);

		if($data['brand'] != null && $data['brand'] > 0){
			$updateData['BrandID'] = $data['brand'];
		}
		if($data['direction'] != null && $data['direction'] > 0){
			$newdatadetail['DirectionID'] = $data['direction'];
		}

		$this->db->where('ProductID', $productId);
		$this->db->update('product', $updateData);

		$this->saveProductAssets($productId, $assets);
		$this->saveProductDetail($productId, $newdatadetail);
		// update
		return $productId;
	}

	public function saveNewPost($data, $assets){
		$this->output->enable_profiler(TRUE);
		// Get Unit
		$this->db->where("UnitID", $data['unit']);
		$query = $this->db->get("unit");
		$unit = $query->row();

		$dateOne = DateTime::createFromFormat("d/m/Y", $data['from_date']);
		$dateTwo = DateTime::createFromFormat("d/m/Y", $data['to_date']);

		$newdata = array(
			'code' => $data['code'],
			'Title' => $data['title'],
			'Brief' => strip_tags(substr($data['description'], 0, 400).'...'),
			'Price' => $data['price'],
			'PriceString' => ($data['price'] != null && $data['price'] > 0) ? $data['price'].' '.$unit->Title : "Thỏa thuận",
			'Area' => ($data['area'] != null && $data['area'] > 0) ? $data['area'].' m²' : "KXĐ",
			'Thumb' => $data['image'],
			'PostDate' => date('Y-m-d H:i:s'),
			'ModifiedDate' => date('Y-m-d H:i:s'),
			'FromDate' => $dateOne->format('Y-m-d H:i:s'),
			'ExpireDate' => $dateTwo->format('Y-m-d H:i:s'),//date('Y-m-d', strtotime('+1 month')),
			'CityID' => $data['city'],
			'DistrictID' => $data['district'],
			'WardID' => $data['ward'],
			'Street' => $data['street'],
			'CategoryID' => $data['categoryID'],
			'Status' => $data['status'],
			'View' => 0,
			'CreatedByID' => $data['CreatedByID'],
			'UnitID' => $data['unit'],
			'Address' => $data['address'],
			'Vip' => $data['vip'],
			'IpAddress' => $data['ipaddress']
		);
		$newdatadetail = array(
			'Detail' => $data['description'],
			'Floor' => $data['floor'],
			'Room' => $data['room'],
			'Toilet' => $data['toilet'],
			'WidthSize' => $data['width'],
			'LongSize' => $data['long'],
			'Longitude' => $data['longitude'],
			'Latitude' => $data['latitude'],
			'ContactPhone' => $data['contact_phone'],
			'ContactAddress' => $data['contact_address'],
			'ContactEmail' => $data['txt_email'],
			'ContactName' => $data['contact_name'],
			'Source' => null
		);
		if($data['brand'] != null && $data['brand'] > 0){
			$newdata['BrandID'] = $data['brand'];
		}
		if($data['direction'] != null && $data['direction'] > 0){
			$newdatadetail['DirectionID'] = $data['direction'];
		}
		$this->db->insert('product', $newdata);
		$insert_id = $this->db->insert_id();
		$this->saveProductAssets($insert_id, $assets);
		$this->saveProductDetail($insert_id, $newdatadetail);
		if($data['vip'] == PRODUCT_STANDARD && $data['CreatedByID'] != null){
			$this->increaseStandardPost($data['CreatedByID']);
		}
		$this->increaseTotalPost($data['CreatedByID']);

		return $insert_id;
	}

	private function increaseStandardPost($userId){
		$this->db->set('StandardPost', 'StandardPost + 1', false);
		$this->db->where('Us3rID', $userId);
		$this->db->update('us3r');
	}

	private function increaseTotalPost($userId){
		$this->db->set('TotalPost', 'TotalPost + 1', false);
		$this->db->where('Us3rID', $userId);
		$this->db->update('us3r');
	}

	public function changeStatusPost($productId, $status){
		$this->db->set('Status', $status);
		$this->db->where('ProductID', $productId);
		return $this->db->update('product');
	}

	public function updateCoordinator($productId, $longitude, $latitude){
		$this->db->set('Longitude', $longitude);
		$this->db->set('Latitude', $latitude);
		$this->db->where('ProductID', $productId);
		$this->db->update('productdetail');
	}

	public function deleteById($productId){
		$this->db->delete('productasset', array('ProductID' => $productId));
		$this->db->delete('productdetail', array('ProductID' => $productId));
		$this->db->delete('sitemap', array('ProductID' => $productId));
		$this->db->delete('purchasehistory', array('ProductID' => $productId));
		$this->db->delete('product', array('ProductID' => $productId));
	}

	private function saveProductDetail($productId, $data){
		if($productId != null && $productId > 0 && $data != null && count($data) > 0){
			// delete old items
			$this->db->delete('productdetail', array('ProductID' => $productId));
			$data['ProductID'] = $productId;
			$this->db->insert('productdetail', $data);
		}
	}

	private function saveProductAssets($productId, $assets){

		$this->db->delete('productasset', array('ProductID' => $productId));
		if($productId != null && $productId > 0 && $assets != null){
			// Save assets
			foreach ($assets as $asset){
				$newdata = array(
					'ProductID' => $productId,
					'Url' => trim($asset, "'"),
					'Name' => basename(trim($asset, "'")),
				);
				$this->db->insert('productasset', $newdata);
			}
		}
	}

	public function searchByProperties($keyword, $catId, $offset, $limit){
		//$this->output->enable_profiler(TRUE);
		$sql = 'select p.* from product p inner join category c on p.CategoryID = c.CategoryID';
		$sql .= ' where p.status = '.ACTIVE;
		if(isset($keyword)){
			$sql .= ' and p.Title like \'%' . $keyword .'%\'';
		}
		if(isset($catId) && $catId > -1) {
			$sql .= ' and (p.CategoryID = ' . $catId . ' OR c.ParentID = ' . $catId . ')';
		}

		$sql .= ' order by date(p.modifieddate) desc';
		$sql .= ' limit '.$offset.','.$limit;

		$countsql = 'select count(*) as total from product p inner join category c on p.CategoryID = c.CategoryID where p.Status = '.ACTIVE;
		if(isset($keyword)){
			$countsql .= ' and p.Title like \'%' . $keyword .'%\'';
		}
		if(isset($catId) && $catId > -1) {
			$countsql .= ' and (p.CategoryID = ' . $catId . ' OR c.ParentID = ' . $catId . ')';
		}

		$products = $this->db->query($sql);
		$total = $this->db->query($countsql);

		$data['products'] = $products->result();
		$total = $total->row();
		$data['total'] = $total->total;
		return $data;
	}

	function findAndFilter($offset, $limit, $st, $categoryId, $status, $orderField, $orderDirection){
		// $this->output->enable_profiler(TRUE);

		if($status != null && $status > -1){
			$this->db->where('p.Status', $status);
		}
		if($categoryId != null){
			$this->db->where('c.CategoryID', $categoryId);
		}
		//$query = $this->db->like('Title', $st)->limit($limit, $offset)->order_by($orderField, $orderDirection)->get('product');

		$query = $this->db->select('p.*, u.FullName, c.CatName')
			->from('product p')
			->join('us3r u', 'u.Us3rID = p.CreatedByID', 'left')
			->join('category c', 'c.CategoryID = p.CategoryID', 'left')
			->like('Title', isset($st) ? $st : "")
			->limit($limit, $offset)
			->order_by($orderField, $orderDirection)
			->get();

		$result['items'] = $query->result();

		if($status != null && $status > -1){
			$this->db->where('Status', $status);
		}
		$query = $this->db->like('Title', $st)->get('product');
		$result['total'] = $query->num_rows();
		return $result;
	}

	function findByPhoneNumber($offset, $limit, $phoneNumber){
		$sql = "select p.*, u.FullName from product p left join us3r u on p.CreatedByID = u.Us3rID where p.productid in(select productid from productdetail where contactphone like '%{$phoneNumber}%' or contactmobile like  '%{$phoneNumber}%' )";
		$sql .= " limit ".$offset.','.$limit;
		$query = $this->db->query($sql);
		$result['items'] = $query->result();

		$countsql = "select count(*) as Total from product p where p.productid in(select productid from productdetail where contactphone like '%{$phoneNumber}%' or contactmobile like  '%{$phoneNumber}%' )";
		$querycount = $this->db->query($countsql);
		$result['total'] = $querycount->row()->Total;

		return $result;
	}

	function findUserId($offset, $limit, $userId){
		$sql = "select p.*, c.cityname as city, d.districtname as district";
		$sql .= " from product p";
		$sql .= " inner join city c on p.cityid = c.cityid";
		$sql .= " inner join district d on p.districtid = d.districtid";
		$sql .= " where p.status = 1 and p.createdbyid = {$userId}";
		$sql .= " limit {$offset},{$limit}";
		$query = $this->db->query($sql);
		$result['products'] = $query->result();

		$countsql = "select count(*) as Total from product p where p.status = 1 and p.createdbyid = {$userId}";
		$querycount = $this->db->query($countsql);
		$result['total'] = $querycount->row()->Total;

		return $result;
	}

	public function findUnderOneBillion($offset, $limit){
		$sql = 'select p.*, c.cityname as city, d.districtname as district from product p';
		$sql .= ' inner join city c on p.cityid = c.cityid';
		$sql .= ' inner join district d on p.districtid = d.districtid';
		$sql .= ' where p.vip = 5 and p.status = '.ACTIVE;
		$sql .= ' and ((p.Price > 0 and p.Price < 1000 and p.UnitID IN(select UnitID from unit where Code = "MILI")) OR (p.Price <= 1 and p.UnitID IN(select UnitID from unit where Code = "BILI")))';

		$sql .= ' order by date(p.modifieddate) desc, p.vip asc';
		$sql .= ' limit '.$offset.','.$limit;
		$products = $this->db->query($sql);
		return $products->result();
	}
	public function countProductUnderOneBillion(){
		$countsql = 'select count(*) as Total from product p where p.vip = 5 and p.status = '.ACTIVE;
		$countsql .= ' and ((p.Price > 0 and p.Price < 1000 and p.UnitID IN(select UnitID from unit where Code = "MILI")) OR (p.Price <= 1 and p.UnitID IN(select UnitID from unit where Code = "BILI")))';
		$total = $this->db->query($countsql);
		$total = $total->row();
		return $total->Total;
	}

	public function findJustUpdate($offset, $limit){
		$sql = 'select p.*, c.cityname as city, d.districtname as district from product p';
		$sql .= ' inner join city c on p.cityid = c.cityid';
		$sql .= ' inner join district d on p.districtid = d.districtid';
		$sql .= ' where p.status = '.ACTIVE;

		$sql .= ' order by p.modifieddate desc';
		$sql .= ' limit '.$offset.','.$limit;

		$products = $this->db->query($sql);
		return $products->result();
	}
	public function countAllProduct(){
		$countsql = 'select count(*) as Total from product p where p.Status = '.ACTIVE;
		$total = $this->db->query($countsql);
		$total = $total->row();
		return $total->Total;
	}

	public function addOrUpdateProduct($data, $assets){
		$productId = $data['ProductID'];
		if($productId == null){
			$newdata = array(
				'Code' => $data['Code'],
				'Title' => $data['Title'],
				'Brief' => $data['Brief'],
				'Description' => $data['Description'],
				'Price' => $data['Price'],
				'Thumb' => $data['Thumb'],
				'PostDate' => date('Y-m-d H:i:s'),
				'ModifiedDate' => date('Y-m-d H:i:s'),
				'CategoryID' => $data['CategoryID'],
				'BrandID' => $data['BrandID'],
				'Status' => $data['Status'],
				'CreatedByID' => $data['CreatedByID']
			);
			$this->db->insert('product', $newdata);
			$insert_id = $this->db->insert_id();
			$this->saveProductAssets($insert_id, $assets);
			return $insert_id;
		} else {
			$this->db->set('Code', $data['Code']);
			$this->db->set('Title', $data['Title']);
			$this->db->set('Price', $data['Price']);
			$this->db->set('Brief', $data['Brief']);
			$this->db->set('Description', $data['Description']);
			$this->db->set('Status', $data['Status']);
			$this->db->set('CategoryID', $data['CategoryID']);
			$this->db->set('BrandID', $data['BrandID']);
			if(strlen($data['Thumb']) > 0){
				$this->db->set('Thumb', $data['Thumb']);
			}
			$this->db->set('ModifiedDate', date('Y-m-d H:i:s'));
			$this->db->where('ProductID', $productId);
			$this->db->update('product');
			$this->saveProductAssets($productId, $assets);
		}

	}

	public function loadAvailableProducts($offset, $limit, $categoryId, $productName, $orderField, $orderDirection){
		$query = $this->db->select('p.*')
			->from('product p')
			->where('p.Status', ACTIVE)
			->limit($limit, $offset)
			->get();
		$data['products'] = $query->result();

		$this->db->where('Status', ACTIVE);
		$total = $this->db->count_all_results('product');
		$data['total'] = $total;
		return $data;
	}

	public function topNewProducts($totalNum){
		$query = $this->db->select('p.*')
			->from('product p')
			->where('p.Status', ACTIVE)
			->limit($totalNum, 0)
			->order_by('PostDate', 'DESC')
			->get();
		return $query->result();
	}

	public function topBestSellerProducts($totalNum){
		$query = $this->db->select('od.ProductID, p.Brief, p.Price, p.Title, p.Thumb, count(*) as NumOfSell')
			->from('orderdetail od')
			->join('product p', 'p.ProductID = od.ProductID', 'inner')
			->where('p.Status', ACTIVE)
			->limit($totalNum, 0)
			->group_by('p.ProductID')
			->order_by('NumOfSell', 'DESC')
			->get();
		return $query->result();
	}

	public function getNewProductCode(){
		$sql = 'select p.Code from product p';
		$sql .= ' order by p.PostDate desc';
		$sql .= ' limit 1';
		$productCodes = $this->db->query($sql);
		$code = $productCodes->row();
		if($code != null){
			$newCode = (int)str_replace('P-', '', $code->Code) + 1;
			if($newCode < 10){
				return "P-0000".$newCode;
			} else if($newCode < 100){
				return "P-000".$newCode;
			} else if($newCode < 1000){
				return "P-0".$newCode;
			} else if($newCode < 10000){
				return "P-".$newCode;
			}
		}else {
			return "P-00001";
		}
	}

	public function findProductByCodeOrTitle($query, $catId = null){
		$where = "p.Status = ".ACTIVE;
		if($catId != null && $catId > 0){
			$where .= " AND p.CategoryID = ". $catId;
		}
		$query = $this->db->select('p.*')
			->from('product p')
			->where($where)
			->group_start()
			->like('p.Code', $query)
			->or_like('p.Title', $query)
			->group_end()
			->limit(10, 0)
			->order_by('Title', 'ASC')
			->get();
		return $query->result();
	}

	public function findMoreProductByMapID($productMap){
		$result = array();
		foreach ($productMap as $proID => $qty){
			$this->db->select('Title, Thumb');
			$this->db->where('ProductID', $qty['ProductID']);
			$query = $this->db->get("product");
			$r =  $query->row();
			$item = array("ProductID"=>$qty['ProductID'], "Quantity"=>$qty["Quantity"], "Title"=>$r->Title, "Thumb"=>$r->Thumb);

			array_push($result, $item);
		}
		return $result;
	}

}
