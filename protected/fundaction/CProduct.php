<?php

use GuzzleHttp\json_decode;
/**
 * Class CProduct
 * @author phil
 */
class CProduct
{
    //审核
    public static function shenhe($publish_goods_sign,$is_through,$goodsmodelname,$n_reason,$manager)
    {
        if($publish_goods_sign == 0)
        {
            $title = '商品审核';
            $con = "<div><a href='http://ydadmin.rdbuy.com.cn'>点击链接对商品<span style='color: red'>$goodsmodelname</span>进行审核。</a></div><div>上传人：$manager</div>";
            $shen_arr = CManage::searchManager_bySign($sign=1);
        }
        if($publish_goods_sign == 1)
        {
            $title = '商品审核';
            if($is_through==1)
            {
                $con = "<div><a href='http://ydadmin.rdbuy.com.cn'>未通过审核，原因：{$n_reason}，点击链接对商品<span style='color: red'>$goodsmodelname</span>进行编辑。</a></div><div>初审：$manager</div>";
                $shen_arr = CManage::searchManager_bySign0($sign=0);
            }else{
                $con = "<div><a href='http://ydadmin.rdbuy.com.cn'>点击链接对商品<span style='color: red'>$goodsmodelname</span>进行审核。</a></div><div>初审：$manager</div>";
                $shen_arr = CManage::searchManager_bySign($sign=2);
            }
        }
        if($publish_goods_sign == 2)
        {
            $title = '商品审核';
            if($is_through==1){
                if($is_through=='')
                {
                    $con = "<div><a href='http://ydadmin.rdbuy.com.cn'>未通过审核，原因：{$n_reason}，点击链接对商品<span style='color: red'>$goodsmodelname</span>进行编辑。</a></div><div>终审：$manager</div>";
                }else{
                    $con = "<div><a href='http://ydadmin.rdbuy.com.cn'>未通过审核，原因：{$n_reason}，点击链接对商品<span style='color: red'>$goodsmodelname</span>进行编辑。</a></div><div>终审：$manager</div>";
                }
                $shen_arr = CManage::searchManager_bySign1();
            }else{
                $con = "<div><a href='http://ydadmin.rdbuy.com.cn'>通过审核，点击链接查看商品<span style='color: red'>$goodsmodelname</span>。</a></div><div>终审：$manager</div>";
                $shen_arr = CManage::searchManager_bySign1();
            }
        }
        foreach ($shen_arr as $sk=>$sv)
        {
            $flag[] = CEmail::sendMail($sv['email'],$title,$con);
        }
        if($flag)
            return true;
    }
	  //通过商品型号id查找该商品的规格
	  public static function search_attr_bymodelid($id)
	  {
	  		$result = Yii::app()->db->createCommand("SELECT * FROM `goods_sku` WHERE goods_model_id=:id")
	  		->bindParam(':id',$id)->queryAll();
	  		echo '<pre>';
	  		foreach($result as $k=>$v)
	  		{
	  		    foreach(explode(';', $v['combination']) as $kk=>$vv)
	  		    {
	  		        $aa[] = $vv;
	  		    }
	  		}
	  		$bb = array_unique($aa);
	  		foreach ($bb as $kb=>$vb)
	  		{
	  		    $cc[$kb] = explode(':', $vb);
	  		}
	  		foreach($cc as $ck=>$cv)
	  		{
	  		    $dd[$cv[0]][] = $cv[1];
	  		    $dd['value'] = $cv[0];
	  		}
	  		//var_dump($dd);die;
	  		return $result;
	  }
	  //通过商品型号id查找该商品所属类型
	  public static function search_one_type_bytypeid($type_id)
	  {
	    	$result = Yii::app()->db->createCommand("SELECT * FROM `goods_type` WHERE id=:id AND is_delete=0")
	     	->bindParam(':id',$type_id)->queryRow();
	     	return $result;
	  }
	  //插入商品规格
	  public static function insert_goods_property($name,$sort)
	  {
			$create_time = date("Y-m-d H:i:s",time());
			$sql = 'insert into goods_property (`name`,`sort`,`create_time`) VALUES (:name,:sort,:create_time) ';
			Yii::app()->db->createCommand($sql)->bindValue(':name',$name)->bindValue(':sort',$sort)
            ->bindValue(':create_time',$create_time)->execute();
			$eid = Yii::app()->db->getLastInsertID();
			return $eid;
	  }
	  //插入商品规格属性
	  public static function insert_goods_property_value($id,$name,$sort)
	  {
	    	$create_time = date("Y-m-d H:i:s",time());
	    	$sql = 'insert into goods_property_value (`goods_property_id`,`name_value`,`sort`,`create_time`) VALUES (:goods_property_id,:name_value,:sort,:create_time) ';
	    	$result = Yii::app()->db->createCommand($sql)->bindValue(':goods_property_id',$id)->bindValue(':name_value',$name)
	     	->bindValue(':sort',$sort)->bindValue(':create_time',$create_time)->execute();
	     	$eid = Yii::app()->db->getLastInsertID();
            CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_property','insert');
	    	return $result;
	  }
	  //查询所有商品规格
	  public static function search_property_all()
	  {
			$result = Yii::app()->db->createCommand("SELECT * FROM `goods_property` WHERE id>1 AND is_delete=0")->queryAll();
			foreach($result as $key=>$value)
			{
			      $res = Yii::app()->db->createCommand("SELECT * FROM `goods_property_value` WHERE is_delete=0 and goods_property_id = $value[id] ")->queryAll();
			      foreach($res as $k=>$v)
			      {
			          //echo $v['goods_property_id'].'--'.$v['name_value'].'---'.$v['id'].'</br>';
                      $result[$key]['name_value'][$k] = $v['name_value'];
			      }
			}
			return $result;
	  }
	  /*通过商品规格ID查询规格和属性*/
	  public static function search_property_by_propertyid($id)
	  {
	        $result = Yii::app()->db->createCommand("SELECT * FROM `goods_property` WHERE is_delete=0 AND id =:id")
            ->bindValue(':id',$id)->queryRow();
	        $result_value = Yii::app()->db->createCommand("SELECT name_value FROM `goods_property_value` WHERE goods_property_id =:id and is_delete=0")
            ->bindValue(':id',$id)->queryAll();
	        foreach($result_value as $k=>$v)
	        {
	            /* echo '<pre>';
	  			var_dump($v); */
	            $result['name_value'][$k] = $v['name_value'];
	        }
	        //$result['name_value'] = $result_value
            return $result;
	  }
	  /*添加商品类型*/
	  public static function add_goods_type($type,$property)
	  {
			$create_time = date("Y-m-d H:i:s",time());
			Yii::app()->db->createCommand('INSERT INTO `goods_type` (`type`,`property_id`,`create_time`)
			VALUES (:type,:property_id,:create_time)')
            ->bindParam(':type',$type)->bindParam(':property_id',$property)
			->bindParam(':create_time',$create_time)->execute();
			$eid = Yii::app()->db->getLastInsertID();
            CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_type','insert');
			return $eid;
	  }
	  /*向属性表中添加商品型号id*/
	  public static function add_type_id_to_porperty($id,$type_id)
	  {
	  		Yii::app()->db->createCommand('UPDATE `goods_property` SET goods_type_id=:goods_type_id WHERE id=:id')
            ->bindParam(':id',$id)->bindParam(':goods_type_id',$type_id)->execute();
	  		$eid = Yii::app()->db->getLastInsertID();
            CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_property','insert');
	  		return $eid;
	  }
	 /*更改规格名称*/
	  public static function edit_property_name_byid($id,$name)
	  {
	    	$create_time = date('Y-m-d H:i:s',time());
	    	$result = Yii::app()->db->createCommand("UPDATE `goods_property` SET name=:name,create_time='$create_time' WHERE id=:id")
	  	    ->bindParam(':name',$name)->bindParam(':id',$id)->execute();
            CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_property','update');
	  	    return $result;
	  }
	  /*通过规格id查找商品规格属性*/
	  public static function search_name_value_byid($id)
	  {
			$result = Yii::app()->db->createCommand("SELECT * FROM `goods_property_value` WHERE goods_property_id=:id AND is_delete=0")
			->bindParam(':id',$id)->queryAll();
			if($result)
			{
			    foreach($result as $k=>$v)
			    {
			        $name_value_arr[$v['id']]['name_value'] = $v['name_value'];
			        $name_value_arr[$v['id']]['id'] = $v['id'];
			        $name_value_arr[$v['id']]['goods_property_id'] = $v['goods_property_id'];
			    }
			}else{
			    $name_value_arr = array();
			}
			return $name_value_arr;
	  }
	  public static function search_property_name_byid($id)
	  {
	  	    $result = Yii::app()->db->createCommand("SELECT name_value FROM `goods_property_value` WHERE goods_property_id=:id AND is_delete=0")
	        ->bindParam(':id',$id)->queryAll();
	  	    foreach($result as $k=>$v)
	  	    {
	  	        $name_value_arr[$k] = $v['name_value'];
	  	    }
	  	    return $name_value_arr;
	  }
	  /*改变商品规格表中type_id*/
	  public static function edit_property_by_propertyid($goods_type_id,$id)
	  {
			$create_time = date('Y-m-d H:i:s',time());
			$result = Yii::app()->db->createCommand("UPDATE `goods_property` SET goods_type_id=:goods_type_id,create_time='$create_time' WHERE id=:id")
			->bindParam(':goods_type_id',$goods_type_id)->bindParam(':id',$id)->execute();
          CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_property','update');
			return $result;
	  }
	  /*删除商品规格表中type_id*/
	  public static function del_property_by_propertyid($goods_type_id,$id)
	  {
			$create_time = date('Y-m-d H:i:s',time());
			$result = Yii::app()->db->createCommand("UPDATE `goods_property` SET goods_type_id=:goods_type_id,create_time='$create_time' WHERE id=:id")
			->bindParam(':goods_type_id',$goods_type_id)->bindParam(':id',$id)->execute();
          CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_property','update');
			return $result;
	  }
	  /*通过商品类型id重新编辑商品类型*/
	  public static function edittype_byid($type,$id,$str)
	  {
			$create_time = date('Y-m-d H:i:s',time());
			$result = Yii::app()->db->createCommand("UPDATE `goods_type` SET type=:type, property_id=:property_id,create_time='$create_time' WHERE id=:id")
			->bindParam(':id',$id)->bindParam(':type',$type)->bindParam(':property_id',$str)->execute();
          CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_type','update');
			return $result;
	  }
	  /*根据商品规格id添加商品属性*/
	  public static function add_name_value($id,$name_value)
	  {
			$create_time = date("Y-m-d H:i:s",time());
			Yii::app()->db->createCommand('INSERT INTO `goods_property_value` (`name_value`,`goods_property_id`,`create_time`)
		    VALUES (:name_value,:goods_property_id,:create_time)')
			->bindParam(':name_value',$name_value)->bindParam(':goods_property_id',$id)
			->bindParam(':create_time',$create_time)->execute();
			$eid = Yii::app()->db->getLastInsertID();
          CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_property_value','insert');
			return $eid;
	  	
	  }
	  /*根据规格属性ID删除符合条件的属性*/
	  public static function del_name_value($str)
	  {	
	  		$create_time = date('Y-m-d H:i:s',time());
	  		$result = Yii::app()->db->createCommand("UPDATE `goods_property_value` SET is_delete=1,create_time='$create_time' WHERE id in($str)")
                ->execute();
          CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_property_value','delete');
	  		return $result;
	  }
	  /*根据规格规格ID查找符合条件的规格*/
	  public static function search_property_byid($str)
	  { 
	        $str = rtrim($str,',');
	        $result = Yii::app()->db->createCommand("SELECT name FROM `goods_property` WHERE is_delete=0 and id in ($str)")
				->queryAll();
	        foreach($result as $k=>$v)
	        {
	            $proper .= $v['name'].',';
	        }
	        return rtrim($proper,',');
	  }
	  /*删除该规格*/
	  public static function del_type_byid($id)
	  {
			$create_time = date('Y-m-d H:i:s',time());
			$result = Yii::app()->db->createCommand("UPDATE `goods_type` SET is_delete=1,create_time='$create_time' WHERE id =:id")
                ->bindParam(':id',$id)->execute();
          CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_type','delete');
			return $result;
	  }
	  /*删除该规格*/
	  public static function del_property_byid($id)
	  {
	        $create_time = date('Y-m-d H:i:s',time());
	        $result = Yii::app()->db->createCommand("UPDATE `goods_property` SET is_delete=1,create_time='$create_time' WHERE id =:id")
                ->bindParam(':id',$id)->execute();
	        if($result)
	        {
	            /*还要删除该规格下的所有属性*/
	            $result = Yii::app()->db->createCommand("UPDATE `goods_property_value` SET is_delete=1,create_time='$create_time' WHERE goods_property_id=:id")
			  		->bindParam(':id',$id)->execute();
                CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_property','delete');
                CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_property_value','delete');
	            return $result;
	        }
	  }
    /*根据property_id，property_name_val删除property_name_val删除*/
    public static function del_propertyName_byPropertyId($property_id,$property_name_val)
    {
        $result = Yii::app()->db->createCommand('DELETE FROM goods_property_value WHERE goods_property_id=:goods_property_id AND name_value=:name_value')
            ->bindParam(':goods_property_id',$property_id)->bindParam(':name_value',$property_name_val)->execute();
        return $result;
    }
	  /*删除该规格ID下的所有属性*/
	  public static function del_all_property_name($id)
	  {
	        $result = Yii::app()->db->createCommand('DELETE FROM goods_property_value WHERE goods_property_id=:id')
                ->bindParam(':id',$id)->execute();
          CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_property_value','delete');
	        return $result;
	  }
	  public static function add_all_property_name($id,$name)
	  {
	  		$create_time = date('Y-m-d H:i:s',time());
	  		$result = Yii::app()->db->createCommand('INSERT INTO `goods_property_value` (`goods_property_id`,`name_value`,`create_time`) VALUES (:goods_property_id,:name_value,:create_time)')
                ->bindParam(':goods_property_id',$id)->bindParam(':name_value',$name)->bindParam(':create_time',$create_time)->execute();
          CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_property_value','insert');
	  		return $result;
	  }
	  /*删除该规格ID下的所有属性*/
	  public static function del_all_name_value($id)
	  {
	        $create_time = date('Y-m-d H:i:s',time());
	        $result = Yii::app()->db->createCommand("UPDATE `goods_property_value` SET is_delete=1,create_time='$create_time' WHERE goods_property_id=:id")
                ->bindParam(':id',$id)->execute();
          CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_property_value','delete');
	        return $result;
	  }
	  //通过商品类型id查找sku
        public static function searchSkuArr_byModelId($model_id)
        {
            $result = Yii::app()->db->createCommand("SELECT * FROM `goods_sku` WHERE is_delete=0 AND goods_model_id=:goods_model_id")
            ->bindParam(':goods_model_id',$model_id)->queryAll();
            return $result;
        }
	  /*查找所有商品类型*/
	  /*通过商品类型查找该商品类型下所有规格以及规格下的所有属性*/
	  public static function search_property_bytypeid($type_id)
	  {
	        $result = Yii::app()->db->createCommand("SELECT * FROM `goods_property` WHERE is_delete=0 AND goods_type_id=:goods_type_id")
	  			->bindParam(':goods_type_id',$type_id)->queryAll();
	        foreach($result as $k=>$v)
	        {
	            $result[$k]['property'] = array_values(self::search_name_value_byid($v['id']));
	        }
	        return $result;
	  }
	  public static function search_type_all()
	  {
	        $result = Yii::app()->db->createCommand("SELECT * FROM `goods_type` WHERE id>1 AND is_delete=0")->queryAll();
	        foreach($result as $k=>$v)
	        {
	            $result[$k]['property'] = self::search_property_byid($v['property_id']);
	            //var_dump($result[$k]['property']);
            }
            return $result;
	  }
        public static function delSkuGroup_byskuid($sku_id)
        {
            $result = Yii::app()->db->createCommand('DELETE FROM `goods_property_group` WHERE goods_sku_id=:goods_sku_id')
                ->bindParam(':goods_sku_id',$sku_id)->execute();
            if($result)
            {
                CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'specification_packing','update');
            }
            return $result;
        }
	  //通过combination 查找skuid
        public static function searchSkuId_byCombination($combination,$model_id)
        {
            $result = Yii::app()->db->createCommand("SELECT id FROM `goods_sku` WHERE is_delete=0 AND goods_model_id=:goods_model_id AND combination=:combination")
            ->bindParam(':combination',$combination)->bindParam(':goods_model_id',$model_id)->queryRow();
            if (self::delSkuGroup_byskuid($result['id'])&&self::delSku_byCombination($result['id']))
            {
                return true;
            }else{
                return false;
            }
        }
	  //删除商品sku
        public static function delSku_byCombination($sku_id)
        {
            $result = Yii::app()->db->createCommand("DELETE FROM `goods_sku` WHERE id=:id")
                ->bindParam(':id',$sku_id)->execute();
            if($result)
            {
                CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_sku','update');
            }
            return $result;
        }
        public static function ss($combination,$model_id)
        {
            $result = Yii::app()->db->createCommand("SELECT id FROM `goods_sku` WHERE is_delete=0 AND goods_model_id=:goods_model_id AND combination=:combination")
                ->bindParam(':combination',$combination)->bindParam(':goods_model_id',$model_id)->queryRow();
            return $result['id'];
        }
        /*更新sku*/
        public static function saveSku($goodsmodelid,$k,$v)
        {
            if($v['delivery_time'] == '0')
            {
                $v['delivery_time']=1;
            }
            $create_time = date("Y-m-d H:i:s",time());
            $skuid = self::ss($k,$goodsmodelid);
            //return $skuid;
            if($skuid)
            {
                $sql = "UPDATE `goods_sku` SET price1=$v[sku_price],market_price=$v[market_price],stock1=$v[stock_num],sales=$v[sales],pn='$v[sku_pn]',delivery_time=$v[delivery_time],create_time='$create_time' WHERE id=$skuid";
                $result = Yii::app()->db->createCommand($sql)->execute();//返回受影响行数
            }
            CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_classfiy','update');
            return $result;
        }
    /*更新sku*/
    public static function saveSku1($skuid,$sku_price,$market_price,$stock_num,$sales,$sku_pn,$delivery_time)
    {
        $create_time = date("Y-m-d H:i:s",time());
        $sql = "UPDATE `goods_sku` SET price1=$sku_price,market_price=$market_price,stock1=$stock_num,sales=$sales,pn='$sku_pn',delivery_time=$delivery_time,create_time='$create_time' WHERE id=$skuid";
        $result = Yii::app()->db->createCommand($sql)->execute();//返回受影响行数
        if($result)
        {
            CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_classfiy','update');
        }
        return $result;
    }
	  /*添加商品sku*/
	  public static function add_sku($model_id,$combination,$sku_price,$market_price,$stock,$sales_volume,$pn,$delivery_time,$is_delete='0')
	  {
	  		//echo $model_id.'-'.$combination.'-'.$sku_price.'-'.$market_price.'-'.$stock.'-'.$sales_volume.'-'.$pn.'-'.$delivery_time;die;
            //$modelId,$combination,$v1['sku_price'],$v1['market_price'],$v1['stock_num'],$v1['sales'],$v1['pn']
            $create_time = date("Y-m-d H:i:s",time());
            Yii::app()->db->createCommand('INSERT INTO `goods_sku` (`goods_model_id`,`combination`,`price1`,`market_price`,`stock1`,`sales`,`pn`,`delivery_time`,`is_delete`,`create_time`)
		        VALUES (:goods_model_id,:combination,:price1,:market_price,:stock1,:sales,:pn,:delivery_time,:is_delete,:create_time)')
	  			->bindParam(':goods_model_id',$model_id)->bindParam(':combination',$combination)
	  			->bindParam(':price1',$sku_price)->bindParam(':market_price',$market_price)->bindParam(':stock1',$stock)
                ->bindParam(':sales',$sales_volume)->bindParam(':pn',$pn)->bindParam(':delivery_time',$delivery_time)
                ->bindParam(':is_delete',$is_delete)->bindParam(':create_time',$create_time)->execute();
            $eid = Yii::app()->db->getLastInsertID();
            if($eid)
            {
                $attr_arr = explode(";",$combination);
                foreach ($attr_arr as $k=>$v)
                {
                    $kv_arr[$k] = explode(':', $v);
                }
                foreach($kv_arr as $key=>$val)
                {
                    self::add_sku_group($eid,$val[0],$val[1]);
                }
            }
          CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_sku','insert');

            return $eid;
	  }
	  /*添加商品sku_group*/
	  public static function add_sku_group($sku_id,$property_id,$property_value_id)
	  {
	  		$create_time = date("Y-m-d H:i:s",time());
	  		Yii::app()->db->createCommand('INSERT INTO `goods_property_group` (`goods_sku_id`,`goods_property_id`,`goods_property_value_id`,`create_time`)
		        VALUES (:goods_sku_id,:goods_property_id,:goods_property_value_id,:create_time)')
	  		    ->bindParam(':goods_sku_id',$sku_id)->bindParam(':goods_property_id',$property_id)
	  		    ->bindParam(':goods_property_value_id',$property_value_id)
	  		    ->bindParam(':create_time',$create_time)->execute();
	  		$eid = Yii::app()->db->getLastInsertID();
          CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_property_group','insert');
	  		return $eid;
	  }
      //类别处理
       public static function foo($id)
       {
             $result = Yii::app()->db->createCommand("SELECT * FROM `goods_classfiy` WHERE id=:id AND is_delete=0")->bindParam(':id',$id)->queryRow();
               if($result['pid'] != 0)
               {
                       return self::foo($result['pid']);
               }
               else{
                       return $result['id'];
               }
        }
        //查找所有类别
        public static function searchCateall($where='')
        {
                $result = Yii::app()->db->createCommand("SELECT * FROM `goods_classfiy` $where WHERE is_delete=0 ORDER BY sort")->queryAll();
                return $result;
        }
       public static function searchCateall1($where='')
       {
               $result = Yii::app()->db->createCommand("SELECT * FROM `goods_classfiy` $where and is_delete=0 ORDER BY sort")->queryAll();
               return $result;
       }
    //通过cateid 查找类别名称
        public static function searchcate_Byid($id)
        {
                $result = Yii::app()->db->createCommand('SELECT id,name,image_url,image_url1 FROM `goods_classfiy` WHERE id=:id AND is_delete=0')->bindParam(':id',$id)->queryRow();
                return $result;
        }
        //直接查找所有类别下的所有商品型号
        public static function searchModelalls()
        {
                $result = Yii::app()->db->createCommand('SELECT * FROM `goods_classfiy` WHERE is_delete=0 ORDER BY sort')->queryAll();
                return $result;
        }
        public static function getcategoryList()
        {
                $result = Yii::app()->db->createCommand('SELECT * FROM `goods_classfiy` WHERE is_delete=0 ORDER BY sort')->queryAll();
                return $result;
        }
        //修改商品类别
        public static function editCategory($id,$sort,$name)
        {
                $sql = 'UPDATE goods_classfiy SET sort = :sort,name=:name WHERE id = :id';
                $result = Yii::app()->db->createCommand($sql)->bindValue(':id',$id)->bindValue(':sort',$sort)->bindValue(':name',$name)->execute();//返回受影响行数
                if($result)
                {
                    CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_classfiy','update');
                }
                return $result;
        }
        //添加商品类别
        public static function addCategory($childName,$childSort,$id,$pth)
        {
        		$create_time = date("Y-m-d H:i:s",time());
                $sql = 'insert into goods_classfiy (`name`,`sort`,`pid`,`create_time`) VALUES (:name,:sort,:pid,:create_time) ';
                Yii::app()->db->createCommand($sql)->bindValue(':name',$childName)->bindValue(':sort',$childSort)
                ->bindValue(':pid',$id)->bindValue(':create_time',$create_time)->execute();
                $eid = Yii::app()->db->getLastInsertID();
                if($eid>=10)
                {
                        $childPth = $pth.$eid.',';
                        $sql2 =  'UPDATE goods_classfiy SET pth = :pth,pid=:pid WHERE id = :id';
                        $result = Yii::app()->db->createCommand($sql2)->bindValue(':id',$eid)->bindValue(':pth',$childPth)->bindValue(':pid',$id)->execute();//返回受影响行数
                        return $result;
                }
                elseif($eid<10)
                {
                        $childPth = $pth.'0'.$eid.',';
                        $sql2 =  'UPDATE goods_classfiy SET pth = :pth,pid=:pid WHERE id = :id';
                        $result = Yii::app()->db->createCommand($sql2)->bindValue(':id',$eid)->bindValue(':pth',$childPth)->bindValue(':pid',$id)->execute();//返回受影响行数
                        if($result)
                        {
                            CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_classfiy','update');
                        }
                        return $result;
                }
                else
                {
                        return false;
                }
        }
        //删除商品类别
        public static function delCategory($id,$pth)
        {
                $res = Yii::app()->db->createCommand('SELECT pth FROM `goods_classfiy` ')->queryColumn();
                static $num =0;
                foreach($res as $k=>$v)
                {
                        if(strpos($v,$pth) !== false)
                        {
                            $num = $num+1;
                        }
                }
                if($num<2)
                {
                        $result = Yii::app()->db->createCommand('UPDATE goods_classfiy SET is_delete=1 WHERE id=:id')->bindParam(':id',$id)->execute();
                        if($result)
                        {
                            CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_classfiy','delete');
                        }
                        return $result;
                }
                else
                {
                        return false;
                }
        }
        //得到商品类别的序号(排序)
        public static function getSort($id)
        {
                $result = Yii::app()->db->createCommand('SELECT sort FROM `goods_classfiy` WHERE id=:id')->bindParam(':id',$id)->queryRow();
                return $result['sort'];
        }
        //得到一个商品的ID
        public static function getOne($id)
        {
                $result = Yii::app()->db->createCommand('SELECT * FROM `goods_classfiy` WHERE id=:id')->bindParam(':id',$id)->queryRow();
                return $result;
        }
       /**
        * 品牌处理
        */
        //查找品牌
        public static function searchBrandall()
        {
                $result = Yii::app()->db->createCommand('SELECT * FROM `brand` WHERE is_delete=0')->queryAll();
                return $result;
        }
        //按条件查找品牌
        public static function searchbrand_Bywhere($sql1,$sql2)
        {
                $sql = "SELECT a.*,b.images_url FROM `brand` a LEFT JOIN `images` b ON a.id = b.brand_id WHERE $sql1 $sql2 and a.is_delete=0 and b.is_delete=0";
                $result = Yii::app()->db->createCommand($sql)->queryAll();
                return $result;
        }
        public static function searchBrand($brandname)
        {
                $result = Yii::app()->db->createCommand('SELECT  FROM `brand` WHERE brandname=:brandname and is_delete=0')->bindParam(':brandname',$brandname)->queryRow();
                return $result;
        }
        public static function searchBrandbyid($brandid)
        {
                $result = Yii::app()->db->createCommand('SELECT * FROM `brand` WHERE id=:brandid')->bindParam(':brandid',$brandid)->queryRow();
                return $result;
        }
        //修改品牌
        public static function editBrandbyid($id,$brandname,$new_img,$country,$introduce,$sort,$state)
        {
                $create_time = date("Y-m-d H:i:s",time());
                $sql = "UPDATE brand SET brandname=:brandname,img_url=:img_url,address=:address,introduce=:introduce,create_time=:create_time,sort=:sort,state=:state WHERE id=:id";
                $result = Yii::app()->db->createCommand($sql)
                ->bindParam(':brandname',$brandname)->bindParam(':img_url',$new_img)
                ->bindParam(':address',$country)->bindParam(':introduce',$introduce)->bindParam(':create_time',$create_time)
                ->bindParam(':sort',$sort)->bindParam(':state',$state)->bindParam(':id',$id)->execute();
                if($result)
                {
                     CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'brand','update');
                }
                return $result;
        }
        //修改品牌状态
        public static function editBrandstatebyid($brand_id,$state)
        {
                $sql = "UPDATE brand SET state=:state WHERE id=:id";
                $result = Yii::app()->db->createCommand($sql)->bindParam(':id',$brand_id)->bindParam(':state',$state)->execute();
                if($result)
                {
                     CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'brand','update');
                }
                return $result;
        }
        //查找品牌序号
        public static function searchSort($sort)
        {
                $result = Yii::app()->db->createCommand('SELECT * FROM `brand` WHERE sort=:sort')->bindParam(':sort',$sort)->queryRow();
                return $result;
        }
        //添加品牌
        public static function addBrand($brandname,$img,$address,$discribe,$sort,$state)
        {
                $create_time = date("Y-m-d H:i:s",time());
                Yii::app()->db->createCommand('INSERT INTO `brand` (`brandname`,`img_url`,`address`,`introduce`,`create_time`,`sort`,`state`)
                VALUES (:brandname,:img_url,:address,:introduce,:create_time,:sort,:state)')
                ->bindParam(':brandname',$brandname)->bindParam(':img_url',$img)->bindParam(':address',$address)
                ->bindParam(':introduce',$discribe)->bindParam(':create_time',$create_time)
                ->bindParam(':sort',$sort)->bindParam(':state',$state)->execute();
                $eid = Yii::app()->db->getLastInsertID();
                if($eid)
                {
                     CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'brand','insert');
                }
                return $eid;
        }
        //添加品牌logo
        public static function addBrandlogo($desFilePath,$brand_id,$images_class_id=2)
        {
                $result = Yii::app()->db->createCommand('INSERT INTO `images` (`images_url`,`brand_id`,`images_class_id`) VALUES (:images_url,:brand_id,:images_class_id)')->bindParam(':images_url',$desFilePath)->bindParam(':brand_id',$brand_id)->bindParam(':images_class_id',$images_class_id)->execute();
                if($result)
                {
                    CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'images','insert');
                }
                return $result;
        }

        //修改品牌logo
        public static function editBrandlogo($images_url,$brand_id)
        {
                $result = Yii::app()->db->createCommand('UPDATE images SET images_url = :images_url WHERE brand_id = :brand_id')->bindParam(':images_url',$images_url)->bindParam(':brand_id',$brand_id)->execute();
                if($result)
                {
                     CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'images','update');
                }
                return $result;
        }
        //删除品牌
        public static function delBrandbyid($brand_id,$is_delete)
        {
                $result = Yii::app()->db->createCommand('UPDATE brand SET is_delete=:is_delete WHERE id=:id')
                ->bindParam(':is_delete',$is_delete)->bindParam(':id',$brand_id)->execute();
                if($result)
                {
                    CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'brand','delete');
                }
                return $result;
        }
        //查找所有商品
        public static function searchGoodsall()
        {
                $result = Yii::app()->db->createCommand('SELECT * FROM `goods` where is_delete=0')->queryAll();
                return $result;
        }


        //编辑商品状态
        public static function edit_Goods($goods_id ,$is_publish)
        {
                $result = Yii::app()->db->createCommand('UPDATE `goods` SET is_publish = :is_publish WHERE id=:goods_id')->bindParam(':is_publish',$is_publish)->bindParam(':goods_id',$goods_id)->execute();
                if($result)
                {
                    CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods','update');
                }
                return $result;
        }
        //根据类别ID查找同一类别下的商品
        public static function searchGoods($catid)
        {
                $result = Yii::app()->db->createCommand('SELECT * FROM `goods` WHERE cate = :catid and is_delete=0')->bindParam(':catid',$catid) ->queryAll();
                return $result;
        }
        //根据商品ID查找同一商品下的型号
        public static function searchModels($goodsid)
        {
                $result = Yii::app()->db->createCommand('SELECT * FROM `goods_model` WHERE goods_id = :goods_id AND is_delete=0')->bindParam(':goods_id',$goodsid) ->queryAll();
                return $result;
        }
        //根据型号id查询sku
        public static function searchModelall()
        {
                $result = Yii::app()->db->createCommand('SELECT * FROM `goods_model` WHERE is_delete=0')->queryAll();
                return $result;
        }
        public static function searchModels_byid($model_id)
        {
                $result = Yii::app()->db->createCommand('SELECT * FROM `goods_model` WHERE id = :id AND is_delete=0')->bindParam(':id',$model_id) ->queryRow();
                return $result;
        }
        public static function search_prop_byid($id)
        {
	        	$result = Yii::app()->db->createCommand('SELECT name FROM `goods_property` WHERE id = :id AND is_delete=0')->bindParam(':id',$id) ->queryRow();
	        	return $result;
        }
        //根据skuid查询sku详情
        public static function searchsku_byid($id)
        {
        	$result = Yii::app()->db->createCommand('SELECT * FROM `goods_sku` WHERE id = :id AND is_delete=0')->bindParam(':id',$id) ->queryRow();
        	return $result;
        }
        public static function search_propv_byid($id)
        {
	        	$result = Yii::app()->db->createCommand('SELECT name_value FROM `goods_property_value` WHERE id = :id AND is_delete=0')->bindParam(':id',$id) ->queryRow();
	        	return $result;
        }
        /* //
        public static function search_prop_value_byid($prop_value_id)
        {
        	$result = Yii::app()->db->createCommand('SELECT name_value FROM `goods_property_value` WHERE id = :id AND is_delete=0')->bindParam(':id',$id) ->queryRow();
        	return $result;
        } */
        //根据skuid查找所有sku
        public static function searchGoodsModelSku_name_byskuid($skuid)
        {
        	    $result = Yii::app()->db->createCommand('SELECT a.*,b.model_number,c.name as goods_name FROM `goods_sku` a LEFT JOIN `goods_model` b ON a.goods_model_id=b.id LEFT JOIN `goods` c ON b.goods_id=c.id  WHERE a.id = :id AND a.is_delete=0')
        	    ->bindParam(':id',$skuid) ->queryRow();
            	if($result&&$result['combination'])
            	{
            		$g_attr = explode(';', $result['combination']);
            		foreach($g_attr as $kk=>$vv)
            		{
            			$gg_attr = explode(':', $vv);
            			//var_dump($gg_attr[0]);die;
            			//查找子类型名
            			$prop_name = self::search_prop_byid($gg_attr[0])['name'];
            			//查找子类型值
            			$propv_name = self::search_propv_byid($gg_attr[1])['name_value'];
            			$aa[$kk]=$prop_name.':'.$propv_name.',';
            		}
            	}
            	if(implode('', $aa)==':,')
            	{
            		$result['combination'] = '【'.$result['model_number'].'】';
            	}else{
            		$result['combination'] = '【'.$result['model_number'].'】'.'('.implode('', $aa).')';
            	}
            	return $result['combination'];
        }
        //根据skuid查找所有sku
        public static function searchGoodsModelSku_name_byskuid2($skuid)
        {
        	    $result = Yii::app()->db->createCommand('SELECT a.*,b.model_number,c.name as goods_name FROM `goods_sku` a LEFT JOIN `goods_model` b ON a.goods_model_id=b.id LEFT JOIN `goods` c ON b.goods_id=c.id  WHERE a.id = :id AND a.is_delete=0')
        	    ->bindParam(':id',$skuid) ->queryRow();
            	if($result&&$result['combination'])
            	{
            		$g_attr = explode(';', $result['combination']);
        	    	foreach($g_attr as $kk=>$vv)
        	    	{
        	    		$gg_attr = explode(':', $vv);
        	    		//var_dump($gg_attr[0]);die;
        	       		//查找子类型名
        	    		//$prop_name = self::search_prop_byid($gg_attr[0])['name'];
        	    		//查找子类型值
        		    	$propv_name = self::search_propv_byid($gg_attr[1])['name_value'];
        		    	$aa[$kk]=$propv_name.',';
        	    	}
                    $strr = implode('', $aa);
                    $trim_str = trim($strr,',');
                    if($strr==',')
                    {
                            $result['combination'] = $result['model_number'];
                     }else{
                            $result['combination'] = $result['model_number'].'('.$trim_str.')';
                     }
                  }else{
                        $result['combination']='';
                  }

        	return $result['combination'];
        }
        //根据商品型号id查找所有sku
    public static function searchskus_byid($model_id)
    {
        $result = Yii::app()->db->createCommand('SELECT * FROM `goods_sku` WHERE goods_model_id = :id AND is_delete=0')->bindParam(':id',$model_id) ->queryAll();
        foreach($result as $k=>$v)
        {
            if($v['combination'])
            {
                $g_attr = explode(';', $v['combination']);
                foreach($g_attr as $kk=>$vv)
                {
                    $gg_attr = explode(':', $vv);
                    //var_dump($gg_attr[0]);die;
                    //查找子类型名
                    $prop_name = self::search_prop_byid($gg_attr[0])['name'];
                    //查找子类型值
                    $propv_name = self::search_propv_byid($gg_attr[1])['name_value'];
                    $aa[$kk]=$prop_name.':'.$propv_name.' ';
                }
                //var_dump($aa);die;
            }
            $result[$k]['combination'] = implode(' ', $aa);
        }
        //var_dump($result);die;
        return $result;
    }
        public static function searchskus_byid1($model_id)
        {
        	    $result = Yii::app()->db->createCommand('SELECT * FROM `goods_sku` WHERE goods_model_id = :id AND is_delete=0')->bindParam(':id',$model_id) ->queryAll();

        	    //var_dump($result);die;
        	    return $result;
        }
        //根据商品ID查找商品
        public static function searchGoods_byid($id)
        {
                $result = Yii::app()->db->createCommand('SELECT * FROM `goods` WHERE id = :id')->bindParam(':id',$id) ->queryRow();
                return $result;
        }
        //通过商品型号 查询商品型号详情
        public static function searchmodel_Bymodel($model)
        {
        	    $result = Yii::app()->db->createCommand('SELECT * FROM `goods_model` WHERE model_number = :model_number')->bindParam(':model_number',$model) ->queryRow();
        	    return $result;
        }
        //更改商品库存
        public static function updatastock($model,$stock)
        {
        	    $result = Yii::app()->db->createCommand('UPDATE goods_model SET stock=:stock WHERE model_number=:model_number')
        	    ->bindParam(':stock',$stock)->bindParam(':model_number',$model)->execute();
            CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_model','update');
        	    return $result;
        }
        //添加商品返回商品ID
        public static function addGoods($name,$cate,$business_men,$brand,$create_time,$manual,$function,$is_comments)
        {
                $result = Yii::app()->db->createCommand('INSERT INTO `goods` (`name`,`cate`,`business_men`,`brand`,`create_time`, `manual`,`function`,`is_comments`)
                VALUES(:name,:cate,:business_men,:brand,:create_time,:manual,:function,:is_comments)')
                ->bindParam(':name',$name)->bindParam(':cate',$cate)->bindParam(':business_men',$business_men)
                ->bindParam(':brand',$brand)->bindParam(':create_time',$create_time)->bindParam(':manual',$manual)
                ->bindParam(':function',$function)->bindParam(':is_comments',$is_comments)->execute();
                $eid = Yii::app()->db->getLastInsertID();
                if($result)
                {
                        CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods','insert');
                }
                return $eid;
        }
		//添加商品图片表的商品类别 和商品型号
		public static function addimage($model_id,$images_class_id)
		{
			$create_time = date('Y-m-d H:i:s',time());
			$result = Yii::app()->db->createCommand('INSERT INTO `images` (`images_class_id`,`pid`,`create_time`)
			VALUES (:images_class_id,:pid,:create_time)')
			->bindParam(':images_class_id',$images_class_id)->bindParam(':pid',$model_id)->bindParam(':create_time',$create_time)->execute();
			if($result)
			{
				    CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'images','insert');
			}
			return $result;
			
		}
        //添加商品图片
        public static function addImg($path,$modelId,$sort)
        {
        		$create_time = date('Y-m-d H:i:s',time());
                $result = Yii::app()->db->createCommand('INSERT INTO `images_model` (`image_url`,`model_id`,`sort`,`create_time`) VALUES (:image_url,:model_id,:sort,:create_time)')
                ->bindParam(':sort',$sort)->bindParam(':image_url',$path)
                ->bindParam(':model_id',$modelId)->bindParam(':create_time',$create_time)->execute();
                if($result)
                {
                    CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'images','insert');
                }
                return $result;
        }
        
        //添加商品参数
        public static function addSpecification_packing($model_id,$td_one,$td_two)
        {
                $result = Yii::app()->db->createCommand('INSERT INTO `specification_packing` (`model_id`,`td_one`,`td_two`) VALUES (:model_id,:td_one,:td_two)')->bindParam(':model_id',$model_id)->bindParam(':td_one',$td_one)->bindParam(':td_two',$td_two)->execute();
                if($result)
                {
                    CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'specification_packing','insert');
                }
                return $result;
        }
        /*//修改商品参数
        public static function editSpecification_packing($td_one,$td_two,$model_id)
        {
                $sql = 'UPDATE `specification_packing` SET td_one=:td_one,td_two=:td_two WHERE model_id=:model_id';
                $result = Yii::app()->db->createCommand($sql)
                ->bindParam(':td_one',$td_one)->bindParam(':td_two',$td_two)->bindParam(':model_id',$model_id)->execute();
                return $result;
        }*/
        //删除商品参数
        public static function delSpecification_packing($model_id)
        {
                $result = Yii::app()->db->createCommand('DELETE FROM specification_packing WHERE model_id=:model_id')
                ->bindParam(':model_id',$model_id)->execute();
                if($result)
                {
                    CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'specification_packing','update');
                }
                return $result;
        }
        //查找商品图片
        public static function searchModelPic($goodsmodelid)
        {
            $result = Yii::app()->db->createCommand('SELECT * FROM images_model WHERE model_id=:model_id AND is_delete=0 ORDER BY sort asc')->bindParam(':model_id',$goodsmodelid)->queryAll();
            return $result;
        }
        //查找商品图片顺序
        public static function searchImg($goodsmodelid)
        {
                $result = Yii::app()->db->createCommand('SELECT sort FROM images_model WHERE model_id=:model_id AND is_delete=0')->bindParam(':model_id',$goodsmodelid)->queryAll();
                return $result;
        }
        //查找商品图片顺序
        public static function searchmodelImg($goodsmodelid)
        {
        	    $result = Yii::app()->db->createCommand('SELECT sort FROM images_model WHERE model_id=:model_id')->bindParam(':model_id',$goodsmodelid)->queryAll();
        	    return $result;
        }
        //添加商品pdf
        public static function addPdf($goodsId,$pdf_name,$goods_pdf,$sort)
        {
                $result = Yii::app()->db->createCommand('INSERT INTO `pdf` (`goods_id`,`pdf_name`,`url`,`sort`) VALUES (:goods_id,:pdf_name,:url,:sort)')
                    ->bindParam(':goods_id',$goodsId)->bindParam(':pdf_name',$pdf_name)
                    ->bindParam(':url',$goods_pdf)->bindParam(':sort',$sort)->execute();
                if($result)
                {
                    CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'pdf','insert');
                }
                return $result;
        }
        //查找商品pdf
        public static function searchPdf($goodsid)
        {
                $result = Yii::app()->db->createCommand('SELECT * FROM pdf WHERE goods_id=:goods_id AND is_delete=0')->bindParam(':goods_id',$goodsid)->queryAll();
                return $result;
        }
        //查找商品Specification_packing规格
        public static function searchSpecification_packing($id)
        {
                $result = Yii::app()->db->createCommand('SELECT * FROM specification_packing WHERE model_id=:model_id')->bindParam(':model_id',$id)->queryAll();
                return $result;
        }
        //添加套餐
        public static function addPackage($packagename,$packageprice,$original_price,$discount,$introduce,$endtime,$status)
        {
                $result = Yii::app()->db->createCommand('INSERT INTO `meal` (`name`,`price`,`original_price`,`discount`,`introduce`,`create_time`,`is_delete`)
                VALUES (:name,:price,:original_price,:discount,:introduce,:create_time,:is_delete)')
                ->bindParam(':name',$packagename)->bindParam(':price',$packageprice)->bindParam(':original_price',$original_price)->bindParam(':discount',$discount)
                ->bindParam(':introduce',$introduce)->bindParam(':create_time',$endtime)->bindParam(':is_delete',$status)->execute();
                $eid = Yii::app()->db->getLastInsertID();
                if($result)
                {
                    CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'meal','insert');
                }
                return $eid;
        }
        //添加套餐商品
        public static function addPackage_goodsmodel($packageid,$goods_sku_id,$goods_modelid,$quantity,$unit_price,$difference,$endtime,$status)
        {
                $result = Yii::app()->db->createCommand('INSERT INTO `meal_goods` (`meal_id`,`goods_sku_id`,`goods_model_id`,`quantity`,`unit_price`,`difference`,`create_time`,`is_delete`)
                VALUES (:meal_id,:goods_sku_id,:goods_model_id,:quantity,:unit_price,:difference,:create_time,:is_delete)')
                ->bindParam(':meal_id',$packageid)->bindParam(':goods_sku_id',$goods_sku_id)
                ->bindParam(':goods_model_id',$goods_modelid)->bindParam(':quantity',$quantity)
                ->bindParam(':unit_price',$unit_price)->bindParam(':difference',$difference)->bindParam(':create_time',$endtime)->
                bindParam(':is_delete',$status)->execute();
                if($result)
                {
                   CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'meal_goods','insert');
                }
                return $result;
        }
        
        //查询商品数量
        public static function countModel($goods_id)
        {
                $result = Yii::app()->db->createCommand('SELECT count(*) as sort FROM goods_model WHERE goods_id=:goods_id AND is_delete=0')->bindParam(':goods_id',$goods_id)->queryRow();
                return $result;
        }
        //编辑套餐
        public static function editPackage($package_id,$packagename,$packageprice,$original_price,$discount,$introduce,$endtime,$status)
        {
        		$updata_time = date('Y-m-d H:i:s',time());
                $sql = 'UPDATE meal SET name=:name,price=:price,original_price=:original_price,discount=:discount,introduce=:introduce,create_time=:create_time,updata_time=:updata_time,is_delete=:is_delete WHERE id=:id';
                $result = Yii::app()->db->createCommand($sql)
                ->bindParam(':name',$packagename)->bindParam(':price',$packageprice)->bindParam(':original_price',$original_price)->bindParam(':discount',$discount)
                ->bindParam(':introduce',$introduce)->bindParam(':create_time',$endtime)->bindParam(':updata_time',$updata_time)
                ->bindParam(':is_delete',$status)->bindParam(':id',$package_id)->execute();
                if($result)
                {
                    CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'meal','update');
                }
                return $result;
        }
        //编辑套餐商品
        public static function editPackage_goodsmodel($id,$goods_sku_id,$goods_modelid,$quantity,$unit_price,$difference,$create_time,$status)
        {
        		//echo $id.'--'.$goods_sku_id.'--'.$goods_modelid.'--'.$quantity.'--'.$unit_price.'--'.$difference.'--'.$create_time.'--'.$status;
        		//die;
        		$create_time = date('Y-m-d H:i:s',time());
                $sql = 'UPDATE meal_goods SET goods_sku_id=:goods_sku_id,goods_model_id=:goods_model_id,quantity=:quantity,unit_price=:unit_price,difference=:difference,create_time=:create_time,is_delete=:is_delete WHERE id=:id';
                $result = Yii::app()->db->createCommand($sql)
                ->bindParam(':goods_sku_id',$goods_sku_id)->bindParam(':goods_model_id',$goods_modelid)->bindParam(':quantity',$quantity)
                ->bindParam(':unit_price',$unit_price)->bindParam(':difference',$difference)
                ->bindParam(':create_time',$create_time)->bindParam(':is_delete',$status)->bindParam(':id',$id)->execute();
                if($result)
                {
                     CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'meal_goods','update');
                }
                return $result;
        }
        //根据套餐商品id删除套餐
        public static function delMeal_byMealId($meal_id)
        {
	        	$result = Yii::app()->db->createCommand('UPDATE meal_goods SET is_delete=1 WHERE id=:id')
	        	->bindParam(':id',$meal_id)->execute();
	        	if($result)
	        	{
	        		CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'meal','delete');
	        	}
	        	return $result;
        }
        //查找套餐id
        public static function searchMeal_goodsid($id)
        {
                $result = Yii::app()->db->createCommand('SELECT id FROM meal_goods WHERE meal_id=:id; AND is_delete=0')->bindParam(':id',$id)->queryAll();
                return $result;
        }
        //编辑套餐chanpin状态
        public static function editPackagestate($meal_goods_id,$state)
        {
                $result = Yii::app()->db->createCommand('UPDATE meal_goods SET state=:state WHERE id=:id')
                ->bindParam(':state',$state)->bindParam(':id',$meal_goods_id)->execute();
                if($result)
                {
                    CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'meal','update');
                }
                return $result;
        }

        //删除套餐
        /*public static function delPackage($package_id ,$is_delete=1)
        {
                $result = Yii::app()->db->createCommand('UPDATE meal SET is_delete=1 WHERE id=:id')->bindParam(':id',$package_id)->execute();
                if($result)
                {
                    CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'meal','delete');
                }
                return $result;
        }*/
        //同时也要删除套餐商品类型
        public static function delPackage_model($meal_goods_id)
        {
                $result = Yii::app()->db->createCommand('UPDATE meal_goods SET is_delete=1 WHERE id=:id')->bindParam(':id',$meal_goods_id)->execute();
                if($result)
                {
                    CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'meal_goods','delete');
                }
                return $result;
        }
        //按条件查找套餐
        public static function searchpackage_Bywhere($sql1,$sql2)
        {
                $sql = "SELECT a.*,b.goods_model_id,b.quantity FROM meal a LEFT JOIN meal_goods b ON a.id=b.meal_id WHERE
                $sql1 $sql2 and a.is_delete=0 and b.is_delete=0 ;";
                $result = Yii::app()->db->createCommand($sql)->queryAll();
                return $result;
        }
       //查找套餐
        public static function searchPackage()
        {

                $result = Yii::app()->db->createCommand('SELECT a.*,b.id as meal_goods_id,b.goods_model_id,b.goods_sku_id,b.quantity,b.state,b.unit_price,b.difference FROM meal a LEFT JOIN meal_goods b ON a.id=b.meal_id WHERE a.is_delete=0 and b.is_delete=0 ;')->queryAll();
            	//var_dump($result);die;
            	return $result;
        }
        //根据套餐id查找套餐
        public static function searchPackage_byid($id)
        {
                $result = Yii::app()->db->createCommand('SELECT * FROM meal WHERE id=:id and is_delete=0;')->bindParam(':id',$id)->queryRow();
                return $result;
        }
        //根据套餐id查找套餐商品类型
        public static function searchPackagemodel_byid($id)
        {
                $result = Yii::app()->db->createCommand('SELECT * FROM meal_goods WHERE meal_id=:id and is_delete=0;')->bindParam(':id',$id)->queryAll();
                return $result;
        }
        //查找类型通过类型id
        public static function search_type_byid($id)
        {
        	
        	    $result = Yii::app()->db->createCommand('SELECT * FROM goods_type WHERE id=:id and is_delete=0;')->bindParam(':id',$id)->queryRow();
        	    return $result;
        }
        //类型表插入商品类型
        public static function addgoodsModel($type_id,$goodsId,$title,$goods_list,$model_number,$zi_json,$model_sku_json,$model_attr_json,$stock,$price,$preferential_price,$is_publish,$is_preferential,$sales_volume,$pn,$in_storage,$associated,$after_sales,$cate,$sort,$is_one,$detail_introduce,$model_delivery_time,$is_price_show,$keywords)
        {
            //echo $type_id.'-'.$goodsId.'-'.$title.'-'.$goods_list.'-'.$model_number.'-'.$zi_json.'-'.$model_sku_json.'-'.$model_attr_json.'-'.$stock.'-'.$price.'-'.$preferential_price.'-'.$is_publish.'-'.$is_preferential.'-'.$sales_volume.'-'.$pn.'-'.$in_storage.'-'.$associated.'-'.$after_sales.'-'.$cate.'-'.$sort.'-'.$is_one.'-'.$detail_introduce.'-'.$model_delivery_time;
              // die;
                $date =date('Y-m-d H:i:s',time());
                $result = Yii::app()->db->createCommand('INSERT INTO `goods_model` (`type_id`,`goods_id`,`title`,`goods_list`,`model_number`,`zi_json`,`model_sku_json`,`model_attr_json`,`stock`,`price`,`preferential_price`,`is_publish`,`is_preferential`,`sales_volume`,`pn`,`in_storage`,`create_time`,`associated`,`after_sales`,`cate_test`,`sort`,`is_one`,`detail_introduce`,`model_delivery_time`,`is_price_show`,`keywords`)
                VALUES (:type_id,:goods_id,:title,:goods_list,:model_number,:zi_json,:model_sku_json,:model_attr_json,:stock,:price,:preferential_price,:is_publish,:is_preferential,:sales_volume,:pn,:in_storage,:create_time,:associated,:after_sales,:cate_test,:sort,:is_one,:detail_introduce,:model_delivery_time,:is_price_show,:keywords)')
                ->bindParam(':type_id',$type_id)->bindParam(':goods_id',$goodsId)->bindParam(':title',$title)->bindParam(':goods_list',$goods_list)->bindParam(':model_number',$model_number)
                ->bindParam(':zi_json',$zi_json)->bindParam(':model_sku_json',$model_sku_json)->bindParam(':model_attr_json',$model_attr_json)->bindParam(':stock',$stock)->bindParam(':price',$price)
                ->bindParam(':preferential_price',$preferential_price)->bindParam(':is_publish',$is_publish)->bindParam(':is_preferential',$is_preferential)
                ->bindParam(':sales_volume',$sales_volume)->bindParam(':pn',$pn)->bindParam(':in_storage',$in_storage)
                ->bindParam(':create_time',$date)->bindParam(':associated',$associated)->bindParam(':after_sales',$after_sales)
                ->bindParam(':cate_test',$cate)->bindParam(':sort',$sort)->bindParam(':is_one',$is_one)
                ->bindParam(':detail_introduce',$detail_introduce)->bindParam(':model_delivery_time',$model_delivery_time)
                ->bindParam(':is_price_show',$is_price_show)->bindParam(':keywords',$keywords)->execute();
                $eid = Yii::app()->db->getLastInsertID();
                if($result)
                {
                    CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_model','insert');
                }
                return $eid;
        }
        //根据skuid查询套餐详情
        public static function searchMealDetail_bySkuid($skuid,$packageid)
        {
        	    $result = Yii::app()->db->createCommand('SELECT a.id,a.meal_id,a.goods_sku_id,a.goods_model_id,a.quantity,a.unit_price,a.difference,a.state,a.create_time,b.name,b.price,b.original_price,b.discount,b.introduce,b.updata_time,b.is_delete,d.id as goods_id,d.cate as cate_id FROM `meal_goods` a LEFT JOIN `meal` b ON a.meal_id=b.id LEFT JOIN `goods_model` c ON a.goods_model_id=c.id LEFT JOIN `goods` d ON c.goods_id=d.id WHERE a.goods_sku_id=:id and a.meal_id=:meal_id and a.is_delete=0;')->bindParam(':id',$skuid)->bindParam(':meal_id',$packageid)->queryRow();
        	    return $result;
        }
        //根据商品类别id 查找商品
        public static function searchgoods_Bycatid($catid)
        {
        	    $result = Yii::app()->db->createCommand('SELECT id,name FROM goods WHERE cate = :cate')
        	    ->bindParam(':cate',$catid)->queryAll();
        	    return $result;
        }

        //添加优酷视频
        public static function addvideo_Bymodelid($model_id,$videoid)
        {
        	    $result=Yii::app()->db->createCommand('UPDATE goods_model SET videoid=:videoid WHERE id=:id')
        	    ->bindParam(':videoid',$videoid)->bindParam(':id',$model_id)->execute();
            CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_model','add_video');
        	    return $result;
        }
        //查找包含优酷视频的产品型号
        public static function search_videoModel()
        {
        	    $result = Yii::app()->db->createCommand("SELECT * FROM goods_model where videoid is not null and is_delete=0")
        	    ->queryAll();
        	    return $result;
        }
        //删除商品的视频
        public static function delvideo_Bymidelid($model_id)
        {
        	    $result = Yii::app()->db->createCommand('UPDATE goods_model SET videoid=null WHERE id=:id')
        	    ->bindParam(':id',$model_id)->execute();
            CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_model','del_video');
        	    return $result;
        }
        //按条件查找商品数量
        public static function search_model_count_bywhere($where='')
        {
        	    $result = Yii::app()->db->createCommand("SELECT count(id) FROM goods_model WHERE $where is_delete=0")->queryRow();
        	    return $result;
        }
        public static function searchGoodsmodelall_num()
        {
            $result = Yii::app()->db->createCommand('SELECT * FROM goods A RIGHT JOIN goods_model B ON A.id=B.goods_id where A.is_delete=0 AND B.is_delete=0')
                ->queryAll();

            return count($result);
        }
        //多条件查询商品（后台搜索）
        public static function search_Bysql_num($sql1,$sql2,$sql3,$sql4,$sql5)
        {
            $sql = "SELECT * FROM goods A RIGHT JOIN goods_model B ON A.id=B.goods_id where $sql1 $sql2 $sql3 $sql4 $sql5 AND A.is_delete=0 AND B.is_delete=0";
            //$sql = "SELECT * FROM `goods` WHERE $sql1 $sql2 $sql3 $sql4 and is_delete=0";
            $result = Yii::app()->db->createCommand($sql)->queryAll();
            return count($result);
        }
        public static function search_Bysql($sql1,$sql2,$sql3,$sql4,$sql5,$page,$size)
        {
            $sql = "SELECT * FROM goods A RIGHT JOIN goods_model B ON A.id=B.goods_id where $sql1 $sql2 $sql3 $sql4 $sql5 AND A.is_delete=0 AND B.is_delete=0 ORDER BY A.id DESC LIMIT :page,:size";
            $result = Yii::app()->db->createCommand($sql)->bindValue(':page',(int)($page-1)*$size)->bindValue(':size',(int)$size)->queryAll();
            return $result;
        }
        public static function search_Bywhere_num($where)
        {
            $sql = "SELECT * FROM goods A RIGHT JOIN goods_model B ON A.id=B.goods_id where $where AND A.is_delete=0 AND B.is_delete=0";
            //$sql = "SELECT * FROM `goods` WHERE $sql1 $sql2 $sql3 $sql4 and is_delete=0";
            $result = Yii::app()->db->createCommand($sql)->queryAll();
            return count($result);
        }
        public static function search_Bywhere($where,$page,$size)
        {
            $sql = "SELECT * FROM goods A RIGHT JOIN goods_model B ON A.id=B.goods_id where $where AND A.is_delete=0 AND B.is_delete=0 ORDER BY A.id DESC LIMIT :page,:size";
            $result = Yii::app()->db->createCommand($sql)->bindValue(':page',(int)($page-1)*$size)->bindValue(':size',(int)$size)->queryAll();
            return $result;
        }
		 //查找所有商品型号
        public static function searchGoodsmodelalls()
        {
                $result = Yii::app()->db->createCommand('SELECT * FROM goods A RIGHT JOIN goods_model B ON A.id=B.goods_id where A.is_delete=0 AND B.is_delete=0;')->queryAll();
                return $result;
        }
        //查找所有商品型号
        public static function searchGoodsmodelall($page,$size)
        {
                $result = Yii::app()->db->createCommand('SELECT * FROM goods A RIGHT JOIN goods_model B ON A.id=B.goods_id where A.is_delete=0 AND B.is_delete=0 ORDER BY A.id DESC LIMIT :page,:size')
                    ->bindValue(':page',(int)($page-1)*$size)->bindValue(':size',(int)$size)->queryAll();
                foreach ($result as $k=>$v)
                {
                    unset($result[$k]['price']);
                    unset($result[$k]['stock']);
                    unset($result[$k]['pn']);
                    unset($result[$k]['preferential_price']);
                    unset($result[$k]['sales_volume']);
                    unset($result[$k]['model_delivery_time']);
                    $sku_arr = CProduct::searchskus_byid($v['id']);
                    foreach ($sku_arr as $kk=>$vv)
                    {
                        if($vv['price1']==0)
                        {
                            unset($sku_arr[$kk]);
                        }
                    }
                    $result[$k]['price'] = reset($sku_arr)['market_price'];
                    $result[$k]['stock'] = reset($sku_arr)['stock1'];
                    $result[$k]['pn'] = reset($sku_arr)['pn'];
                    $result[$k]['preferential_price'] = reset($sku_arr)['price1'];
                    $result[$k]['sales_volume'] = reset($sku_arr)['sales_volume'];
                    $result[$k]['model_delivery_time'] = reset($sku_arr)['delivery_time'];
                }
                return $result;
        }
        //根据id查找商品型号
        public static function searchGoodsmodelbyid($id)
        {
                //$result = Yii::app()->db->createCommand('SELECT * FROM goods A LEFT JOIN goods_model B ON A.id=B.goods_id LEFT JOIN meal_goods C ON C.good_model_id=B.id WHERE B.id=:id;')->bindParam(':id',$id)->queryAll();
                //$result = Yii::app()->db->createCommand('SELECT * FROM goods A LEFT JOIN goods_model B ON A.id=B.goods_id WHERE B.id=:id;')->bindParam(':id',$id)->queryRow();
                $result = Yii::app()->db->createCommand('SELECT * FROM goods A LEFT JOIN goods_model B ON A.id=B.goods_id WHERE B.id=:id ;')->bindParam(':id',$id)->queryRow();
                unset($result['price']);
                unset($result['stock']);
                unset($result['pn']);
                unset($result['preferential_price']);
                unset($result['sales_volume']);
                unset($result['model_delivery_time']);
                $sku_arr = CProduct::searchskus_byid($id);
                foreach ($sku_arr as $k=>$v)
                {
                    if($v['price1']==0)
                    {
                        unset($sku_arr[$k]);
                    }
                }
                $result['price'] = reset($sku_arr)['market_price'];
                $result['stock'] = reset($sku_arr)['stock1'];
                $result['pn'] = reset($sku_arr)['pn'];
                $result['preferential_price'] = reset($sku_arr)['price1'];
                $result['sales_volume'] = reset($sku_arr)['sales_volume'];
                $result['model_delivery_time'] = reset($sku_arr)['delivery_time'];
                return $result;
        }
	    public static function searchGoodsmodelbyid1($id,$packageid)
	    {
	            $result = Yii::app()->db->createCommand('SELECT * FROM `goods` A LEFT JOIN `goods_model` B ON A.id=B.goods_id LEFT JOIN `meal_goods` C ON B.id=C.good_model_id WHERE C.good_model_id=:id AND C.meal_id=:meal_id  AND A.is_delete=0 AND B.is_delete=0 AND C.is_delete=0;')->bindParam(':meal_id',$packageid)->bindParam(':id',$id)->queryRow();
	            //$result = Yii::app()->db->createCommand('SELECT * FROM goods A LEFT JOIN goods_model B ON A.id=B.goods_id WHERE B.id=:id;')->bindParam(':id',$id)->queryRow();
	            //$result = Yii::app()->db->createCommand('SELECT * FROM goods WHERE id=:id;')->bindParam(':id',$id)->queryRow();
	            return $result;
	    }
	    //查询订单详情状态
	    public static function searchGoodsmodelstatus_byid($model_id,$order_id)
	    {
	    	    $result = Yii::app()->db->createCommand('SELECT id,status FROM `order_detail` WHERE goods_model_id=:goods_model_id AND order_id=:order_id  AND is_delete=0 ;')
	    	    ->bindParam(':goods_model_id',$model_id)->bindParam(':order_id',$order_id)->queryRow();
	    	    return $result;
	    }
        //根据modelid查找商品id
        public static function searchGoodsbyid($modelid)
        {
                $result = Yii::app()->db->createCommand('SELECT goods_id FROM goods_model  WHERE id=:id AND is_delete=0;')->bindParam(':id',$modelid)->queryRow();
                return $result;
        }
        //根据modelid查找商品name
        public static function searchGoodsname_byid($modelid)
        {
        	  $result = Yii::app()->db->createCommand('SELECT b.name FROM goods_model a LEFT JOIN goods b ON
        	  a.goods_id = b.id WHERE a.id=:id AND a.is_delete=0;')->bindParam(':id',$modelid)->queryRow();
        	  return $result;
        }
        //根据商品型号ID删除商品类型
        public static function delModelbyid($model_id)
        {
                $result = Yii::app()->db->createCommand('UPDATE goods_model SET is_delete=1 WHERE id=:id')->bindParam(':id',$model_id)->execute();
                if($result)
                {
                    CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_model','delete');
                }
                return $result;
        }
        //根据商品型号ID删除商品类型
        public static function del_Modelbyid($model_id,$is_delete)
        {
        	    $result = Yii::app()->db->createCommand('UPDATE goods_model SET is_delete=:is_delete WHERE id=:id')
        	    ->bindParam(':is_delete',$is_delete)->bindParam(':id',$model_id)->execute();
        	    if($result)
        	    {
        	    	CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_model','delete');
        	    }
        	    return $result;
        }
        //编辑商品类型状态
        public static function edit_Goodsmodel($id,$is_publish)
        {
                $result = Yii::app()->db->createCommand('UPDATE `goods_model` SET is_publish = :is_publish WHERE id=:id')->bindParam(':is_publish',$is_publish)->bindParam(':id',$id)->execute();
                if($result)
                {
                    CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_model','update');
                }
                return $result;
        }

        //根据id编辑商品
        public static function editGoodsbyid ($goodsid,$name,$cate,$brand,$business_men,$create_time,$manual,$create_time,$is_comments,$function)
        {
        	    $create_time = date("Y-m-d H:i:s",time());
                $sql = "UPDATE `goods` SET name=:name,cate=:cate,brand=:brand,business_men=:business_men,create_time=:create_time,manual=:manual,is_comments=:is_comments,function=:function WHERE id=:id";
                $result = Yii::app()->db->createCommand($sql)
                ->bindParam(':name',$name)->bindParam(':cate',$cate)->bindParam(':brand',$brand)
                ->bindParam(':business_men',$business_men)->bindParam(':manual',$manual)
                ->bindParam(':create_time',$create_time)->bindParam(':is_comments',$is_comments)->bindParam(':function',$function)
                    ->bindParam(':id',$goodsid)->execute();
                if($result)
                {
                    CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods','update');
                }
                return $result;
        }
        //根据id编辑商品类型
        public static function editGoodsmodelbyid($type_id,$goodsmodelid,$title,$goods_list,$model_number,$zi_json,$model_sku_json,$model_attr_json,$stock,$price,$preferential_price,$associated,$sales_volume,$after_sales,$is_publish,$is_preferential,$create_time,$cateid,$in_storage,$pn,$is_one,$detail_introduce,$model_delivery_time,$wait_audit,$is_price_show,$keywords)
        {
        		$create_time = date("Y-m-d H:i:s",time());
                $sql = "UPDATE `goods_model` SET type_id=:type_id, title=:title,goods_list=:goods_list,model_number=:model_number,zi_json=:zi_json,model_sku_json=:model_sku_json,model_attr_json=:model_attr_json,stock=:stock,price=:price,associated=:associated,preferential_price=:preferential_price,sales_volume=:sales_volume,after_sales=:after_sales,is_publish=:is_publish,is_preferential=:is_preferential,create_time=:create_time,cate_test=:cate,in_storage=:in_storage,pn=:pn,is_one=:is_one,detail_introduce=:detail_introduce,model_delivery_time=:model_delivery_time,wait_audit=:wait_audit,is_price_show=:is_price_show,keywords=:keywords WHERE id=:id";
                $result = Yii::app()->db->createCommand($sql)
                ->bindParam(':type_id',$type_id)->bindParam(':title',$title)->bindParam(':goods_list',$goods_list)->bindParam(':model_number',$model_number)
                ->bindParam(':zi_json',$zi_json)->bindParam(':model_sku_json',$model_sku_json)->bindParam(':model_attr_json',$model_attr_json)
                ->bindParam(':stock',$stock)->bindParam(':price',$price)->bindParam(':create_time',$create_time)
                ->bindParam(':sales_volume',$sales_volume)->bindParam(':associated',$associated)
                ->bindParam(':preferential_price',$preferential_price)->bindParam(':after_sales',$after_sales)
                ->bindParam(':is_publish',$is_publish)->bindParam(':is_preferential',$is_preferential)
                ->bindParam(':in_storage',$in_storage)->bindParam(':cate',$cateid)->bindParam(':id',$goodsmodelid)
                ->bindParam(':pn',$pn)->bindParam(':is_one',$is_one)->bindParam(':detail_introduce',$detail_introduce)
                ->bindParam(':model_delivery_time',$model_delivery_time)->bindParam(':is_price_show',$is_price_show)
                ->bindParam(':keywords',$keywords)->bindParam(':wait_audit',$wait_audit)->execute();
                if($result)
                {
                    CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_model','update');
                }
               
                return $result;
        }
        //search_model_name_bylike
        public static function search_model_name_bylike($contect_goods)
        {
        	    $result = Yii::app()->db->createCommand()->select('title,id')->from('goods_model')->where(array('like','title',"%$contect_goods%"))->queryAll();
        	    return $result;
        }
		
    //查找所有楼层
        public static function searchlayoutall()
        {
        	$result = Yii::app()->db->createCommand('SELECT * FROM `index_floor` where is_delete = 0 ORDER BY sort')->queryAll();
        	return $result;
        }
//查找所有顶级类别
        public static function searchBigCateall()
        {
                $result = Yii::app()->db->createCommand('SELECT * FROM `goods_classfiy` WHERE pid=0 ORDER BY sort')->queryAll();
                return $result;
        }
        //查找所有顶级对应类别
        public static function searchSmallCateByPid($pid)
        {
        	$result = Yii::app()->db->createCommand('SELECT id,name FROM `goods_classfiy` WHERE pid=:pid ;')->bindParam(':pid',$pid)->queryAll();
        	return $result;
        }
        //查找所有顶级分类对应商品
        public static function searchproductByPid($pid)
        {
        	$result = Yii::app()->db->createCommand('SELECT c.id as cid,c.title as title FROM goods_classfiy a LEFT JOIN goods b ON a.id = b.cate LEFT JOIN goods_model c ON b.id =c.goods_id where c.id is not null AND c.is_delete =0 AND c.is_publish =0 AND a.pid =:pid ;')->bindParam(':pid',$pid)->queryAll();
        	return $result;
        }
//查找所有顶级分类对应品牌
        public static function searchblandByPid($pid)
        {
        	$result = Yii::app()->db->createCommand('SELECT DISTINCT b.brandname,b.id as bid from brand b LEFT JOIN goods a ON b.id =a.brand LEFT JOIN goods_classfiy c ON c.id =a.cate WHERE a.id is not null AND c.pid  =:pid ;')->bindParam(':pid',$pid)->queryAll();
        	return $result;
        }
        //添加首页楼层
        public static function addfloor($first_categorys,$second_categorys,$model_id,$model_id_t,$brand,$adv,$sort)
        {
        	Yii::app()->db->createCommand('INSERT INTO `home_floor` (`first_category`,`second_category`,`model_id`,`model_id_t`,`brand_id`,`image_id`,`sort`)
                VALUES (:first_category,:second_category,:model_id,:model_id_t,:brand,:adv,:sort)')
                        ->bindParam(':first_category',$first_categorys)->bindParam(':second_category',$second_categorys)->bindParam(':model_id',$model_id)->bindParam(':model_id_t',$model_id_t)
                        ->bindParam(':brand',$brand)->bindParam(':adv',$adv)->bindParam(':sort',$sort)->execute();
                        $eid = Yii::app()->db->getLastInsertID();
                        return $eid;
        }
        //按id查找首页楼层      
        public static function searchlayoutid($layout_id)
        {
        	$result = Yii::app()->db->createCommand('SELECT * FROM `home_floor` where id=:id;')->bindParam(':id',$layout_id)->queryAll();
        	return $result;
        }
        //模糊查询商品
       
        //模糊查询文章标题id
        public static function searchlikegoods($product)
        {
        	$result = Yii::app()->db->createCommand()->select('id,title,model_number')->from('goods_model')->where(array('like','model_number',"%$product%"))->queryAll();
        	return $result;
        }
        //广告罗列
       public static function searchadveradvall()
       {
       	$result = Yii::app()->db->createCommand('SELECT * FROM `home_product_three`')->queryAll();
       	return $result;
       }
       //按id查找商品首页,产品页展示图
       public static function searchadverbyid($id)
       {
       	$result = Yii::app()->db->createCommand('SELECT * FROM `home_product_three` where id=:id;')->bindParam(':id',$id)->queryRow();
       	return $result;
       }
       //按分类id查找商品
       public static function searchmodelsbycalsid($id)
       {
       	$result = Yii::app()->db->createCommand('SELECT a.id as aid,a.model_number as model_number FROM `goods_model` a LEFT JOIN `goods` b ON a.goods_id=b.id where a.is_delete =0 and a.is_publish = 0 and b.cate =:cate;')->bindParam(':cate',$id)->queryAll();
       	return $result;
       }
       //修改展示产品
       public static function editadvers($id,$goods_model_id,$sku_id)
       {
       	$result = Yii::app()->db->createCommand('UPDATE `home_product_three` SET goods_model_id =:goods_model_id,goods_sku =:goods_sku WHERE id=:id;')->bindParam(':goods_model_id',$goods_model_id)->bindParam(':goods_sku',$sku_id)->bindParam(':id',$id)->execute();
       	return $result;
       }
       //修改品牌状态
       public static function editadverstatebyid($layout_id,$state)
       {
       	$sql = "UPDATE home_floor SET state=:state WHERE id=:id";
       	$result = Yii::app()->db->createCommand($sql)->bindParam(':id',$layout_id)->bindParam(':state',$state)->execute();
       
       	return $result;
       }
       //删除品牌
       public static function deladversbyid($layout_id,$is_delete)
       {
       	$result = Yii::app()->db->createCommand('UPDATE index_floor SET is_delete=:is_delete WHERE id=:id')
       	->bindParam(':is_delete',$is_delete)->bindParam(':id',$layout_id)->execute();
       
       	return $result;
       }
       
       //按分类id查找商品
       public static function searchlayoutbyid($id)
       {
       $result = Yii::app()->db->createCommand('SELECT * FROM `index_floor` where id =:id;')->bindParam(':id',$id)->queryAll();
       	return $result;
       }
     	 public static function editfloor($id,$first_categorys,$second_categorys,$model_id_t,$model_id,$brand,$adv,$sort){
      	$sql = "UPDATE home_floor SET first_category=:first_categorys,second_category=:second_categorys,model_id_t=:model_id_t,model_id=:model_id,brand_id=:brand,image_id=:adv,sort=:sort WHERE id=:id";
      	$result = Yii::app()->db->createCommand($sql)->bindParam(':id',$id)->bindParam(':first_categorys',$first_categorys)->bindParam(':second_categorys',$second_categorys)->bindParam(':model_id',$model_id)->bindParam(':model_id_t',$model_id_t)->bindParam(':brand',$brand)->bindParam(':sort',$sort)->bindParam(':adv',$adv)->execute();
      }
      public static function editBrandbyids($id,$new_img)
      {
      	    $sql = "UPDATE brand SET img_url=:img_url WHERE id=:id";
      	    $result = Yii::app()->db->createCommand($sql)
      	    ->bindParam(':img_url',$new_img)
      	    ->bindParam(':id',$id)->execute();
      	    if($result)
      	    {
      		    CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'brand','update');
      	    }
      	    return $result;
      }
      
      public static function choose_prop_v($model_id){
          $is_delete=0;
      	    $result = Yii::app()->db->createCommand("SELECT c.*,b.price1,b.stock1,b.pn,b.sales from goods_model as a LEFT JOIN goods_sku as b on a.id=b.goods_model_id LEFT JOIN goods_property_group as c on b.id=c.goods_sku_id where a.id=$model_id")
      	    ->bindParam(':is_delete',$is_delete)->queryAll();
      	    //var_dump($result);die;
      	    return  $result;
      }
      public static function choose_attr_v($model_id)
      {
          $is_delete=0;
      	    $result = Yii::app()->db->createCommand("SELECT model_attr_json from goods_model where id=$model_id")
      	    ->bindParam(':is_delete',$is_delete)->queryRow();
      	    $ss = json_decode($result['model_attr_json'],true);
	        if($ss)
	        {
	      	    foreach($ss as $k=>$v)
	      	    {
	      		    foreach($v['value'] as $kk=>$vv)
	      		    {
	      			    $model_attr_arr[] = $vv;
	      		    }
	      	    }
	            }else{
	    	        $model_attr_arr = '';
	            }
      	    return  json_encode($model_attr_arr);
      }
      //查找商品sku信息
      public static function choose_prop_info($model_id){
      	    $result = Yii::app()->db->createCommand("SELECT b.price1,b.stock1,b.pn,b.sales,b.combination,b.market_price,b.delivery_time from goods_model as a LEFT JOIN goods_sku as b on a.id=b.goods_model_id where a.id=$model_id")
      	    ->queryAll();
      	    return  $result;
      }
      //通过商品型号ID查找skuid
      public static function search_skuid_bymodelid($model_id)
      {
      	    $result = Yii::app()->db->createCommand("SELECT id,combination from goods_sku where goods_model_id=$model_id")
      	    ->queryAll();
      	    return  $result;
      }
      //通过skuid查找sku_group_id
      public static function search_skugroupid_bymodelid($skuid_str)
      {
      	    $result = Yii::app()->db->createCommand("SELECT id from goods_property_group where goods_sku_id in ($skuid_str)")
      	    ->queryAll();
      	    return  $result;
      }
      //通过商品型号id删除sku
      public static function del_sku_bymodelid($modelid)
      {
      		$result = Yii::app()->db->createCommand('DELETE FROM goods_sku WHERE goods_model_id=:goods_model_id')
            ->bindParam(':goods_model_id',$modelid)->execute();
      		if($result)
      		{
      		    CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'specification_packing','update');
      		}
      		return $result;
      }
      //通过skuid删除sku_group
      public static function del_sku_group_byskuid($id)
      {
		     $result = Yii::app()->db->createCommand('DELETE FROM goods_property_group WHERE id=:id')
		     ->bindParam(':id',$id)->execute();
		     if($result)
		     {
		         CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'specification_packing','update');
		     }
		     return $result;
      }
      /*通过商品类型ID添加商品属性*/
      public static function add_goods_attr_bytypeid($type_id,$attr,$attr_val_str)
      {
	      	$create_time = date("Y-m-d H:i:s",time());
	      	$result = Yii::app()->db->createCommand('INSERT INTO `goods_attr` (`attr`,`attr_val_str`,`type_id`,`create_time`)
			VALUES (:attr,:attr_val_str,:type_id,:create_time)')
			->bindParam(':attr',$attr)->bindParam(':attr_val_str',$attr_val_str)
			->bindParam(':type_id',$type_id)->bindParam(':create_time',$create_time)->execute();
			$eid = Yii::app()->db->getLastInsertID();
			return $eid;
      }
      /*通过商品属性ID添加商品属性值*/
      public static function add_goods_attr_val_byattrid($attr_id,$attr_val)
      {
	      	$create_time = date("Y-m-d H:i:s",time());
	      	$result = Yii::app()->db->createCommand('INSERT INTO `goods_attr_val` (`attr_val`,`attr_id`,`create_time`)
			VALUES (:attr_val,:attr_id,:create_time)')
	      	->bindParam(':attr_val',$attr_val)->bindParam(':attr_id',$attr_id)
            ->bindParam(':create_time',$create_time)->execute();
	      	$eid = Yii::app()->db->getLastInsertID();
	      	return $eid;
      }
    //更新attr
    public static function uptateAttr_byAttrId($attr_id,$new_attr_val_str)
    {
        $result = Yii::app()->db->createCommand('UPDATE `goods_attr` SET attr_val_str=:attr_val_str WHERE id=:id')
            ->bindParam(':id',$attr_id)->bindParam(':attr_val_str',$new_attr_val_str)->execute();
        return $result;
    }
      //
      public static function search_attr_byattrid($attr_id)
      {
	      	$result = Yii::app()->db->createCommand('SELECT id,attr_val_str FROM goods_attr WHERE id=:id')
			->bindParam(':id',$attr_id)->queryRow();
			if($result)
			{
			    CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'specification_packing','update');
			}
			return $result;
      }
      //查找typeid下的所有属性
      public static function search_attr_bytypeid($type_id)
      {
	      	$result = Yii::app()->db->createCommand('SELECT * FROM goods_attr WHERE type_id=:type_id')
	      	->bindParam(':type_id',$type_id)->queryAll();
	      	
	      	foreach($result as $k=>$v)
	      	{
	      		$result[$k]['attr_arr'] = self::search_attr_val_byattrid($v['id']);
	      	}
	      	if($result)
	      	{
	      	    CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'specification_packing','update');
	      	}
	      	return $result;
      }
      //查找typeid下的所有属性和值
      public static function search_attr_arr_bytypeid($type_id)
      {
      	    $result = Yii::app()->db->createCommand('SELECT * FROM goods_attr WHERE type_id=:type_id')
      	    ->bindParam(':type_id',$type_id)->queryAll();
      	    foreach($result as $k=>$v)
      	    {
      	    	$result[$k]['attr_val_arr'] = self::search_attr_val_byattrid($v['id']);
      	    }
      	    if($result)
      	    {
      	        CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'specification_packing','update');
      	    }
      	    return $result;
      }
      //查找attr下的所有属性
      public static function search_attr_val_byattrid($attr_id)
      {
	      	$result = Yii::app()->db->createCommand('SELECT * FROM goods_attr_val WHERE attr_id=:attr_id')
	      	->bindParam(':attr_id',$attr_id)->queryAll();
	      	if($result)
	      	{
	      	     CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'specification_packing','update');
	      	}
	      	return $result;
      }
      //通过商品类型ID修改商品属性
      public static function del_attr_bytypeid($type_id)
	  {
	      	$result = Yii::app()->db->createCommand('DELETE FROM goods_attr WHERE type_id=:type_id')
	        ->bindParam(':type_id',$type_id)->execute();
          CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_attr_val','update');
	        return $result;
      }
      //通过商品类型ID修改商品属性
      public static function del_attr_val_by_str($attr_val_id_str)
      {
	      	$result = Yii::app()->db->createCommand("DELETE FROM goods_attr_val WHERE attr_id in ($attr_val_id_str)")
	      	->execute();
          CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_attr_val','update');
	      	return $result;
      }
      //添加商品规格值
      public static function add_property_val($goods_property_id,$name_value)
      {
      		$create_time = date("Y-m-d H:i:s",time());
      		$result = Yii::app()->db->createCommand('INSERT INTO `goods_property_value` (`goods_property_id`,`name_value`,`create_time`)
			VALUES (:goods_property_id,:name_value,:create_time)')
      		->bindParam(':goods_property_id',$goods_property_id)->bindParam(':name_value',$name_value)
      		->bindParam(':create_time',$create_time)->execute();
      		echo Yii::app()->db->getLastInsertID();die;
      }
      //修改商品类型
      public static function edit_goods_type_byid($type_id,$property_id)
      {
      	    $create_time = date("Y-m-d H:i:s",time());
      	    $result = Yii::app()->db->createCommand('UPDATE `goods_type` SET property_id=:property_id WHERE id=:id')
      	    ->bindParam(':id',$type_id)->bindParam(':property_id',$property_id)->execute();
      }
      //添加商品规格
      public static function add_property($type_id,$property)
      {
      	    $create_time = date("Y-m-d H:i:s",time());
      	    $result = Yii::app()->db->createCommand('INSERT INTO `goods_property` (`goods_type_id`,`name`,`create_time`)
		    VALUES (:goods_type_id,:name,:create_time)')
      	    ->bindParam(':goods_type_id',$type_id)->bindParam(':name',$property)
      	    ->bindParam(':create_time',$create_time)->execute();
      	    $essid = Yii::app()->db->getLastInsertID();
      	    $pin = self::search_type_byid($type_id)['property_id'];
      	    $new_pin = $pin.','.$essid;
      	    self::edit_goods_type_byid($type_id,$new_pin);
      	    echo $essid;die;
      }
      //修改attr
      public static function edit_attr_byid($id,$attr)
      {
      	    $create_time = date("Y-m-d H:i:s",time());
      	    $result = Yii::app()->db->createCommand('UPDATE `goods_attr` SET attr_val_str=:attr_val_str WHERE id=:id')
      	    ->bindParam(':id',$id)->bindParam(':attr_val_str',$attr)->execute();
          CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_attr','update');
      	    return $result;
      }
      //查找attr_val
      public static function search_attr_val_byid($id)
      {
      	    $result = Yii::app()->db->createCommand('SELECT * FROM goods_attr_val WHERE id=:id')
      	    ->bindParam(':id',$id)->queryRow();
      	    if($result)
      	    {
      	         CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'specification_packing','update');
      	    }
      	    return $result;
      }
      public static function del_attr_val_byid($attr_id,$attr_val)
      {
      	    $result = Yii::app()->db->createCommand('DELETE FROM goods_attr_val WHERE attr_id=:attr_id AND attr_val=:attr_val')
                ->bindParam(':attr_id',$attr_id)->bindParam(':attr_val',$attr_val)->execute();
      	    return $result;
      }
      
      //根据attrid删除attr
      public static function del_attr_byid($id)
      {
      	    $result = Yii::app()->db->createCommand('DELETE FROM goods_attr WHERE id=:id')
      	    ->bindParam(':id',$id)->execute();
          CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_attr','delete');
      	    return $result;
      }
      //根据attrid删除attr_val
      public static function del_attr_val_byattrid($attr_id)
      {
      	    $result = Yii::app()->db->createCommand('DELETE FROM goods_attr_val WHERE attr_id=:attr_id')
      	    ->bindParam(':attr_id',$attr_id)->execute();
          CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_attr_val','delete');
      	    return $result;
      }
      
      //同过orderid查找userid
      public static function search_userid($orderid)
      {
      	    $result = Yii::app()->db->createCommand('SELECT `user_id` FROM `order` WHERE id=:id')
      	    ->bindParam(':id',$orderid)->queryRow();
      	    return $result;
      }
      public static function search_invoice3_info($userid)
      {
      	    $result = Yii::app()->db->createCommand('SELECT * FROM `invoice3` WHERE user_id=:user_id AND is_delete=1')
      	    ->bindParam(':user_id',$userid)->queryRow();
      	    return $result;
      }
      //开票
    public static function updateOrder_inv($order_id)
    {
            Yii::app()->db->createCommand('UPDATE `order` SET is_invoice=1 WHERE id=:id')
            ->bindParam(':id',$order_id)->execute();
            $eid = Yii::app()->db->getLastInsertID();
        CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'order','up_invoice');
            return $eid;
    }

    //添加售后时间期限
    public static function add_sales_time($name,$returned_time,$exchange_time)
    {
            $result = Yii::app()->db->createCommand('INSERT INTO `sales_type_detail` (`name`,`returned_time`,`exchange_time`)
		    VALUES (:name,:returned_time,:exchange_time)')
            ->bindParam(':name',$name)
            ->bindParam(':returned_time',$returned_time)->bindParam(':exchange_time',$exchange_time)->execute();
        CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'sales_type_detail','insert');
            return $result;
    }

    public static function del_sales_time($time_id)
    {
            $result = Yii::app()->db->createCommand('UPDATE `sales_type_detail` SET is_delete=1 WHERE id=:id')
            ->bindParam(':id',$time_id)->execute();
            Yii::app()->db->getLastInsertID();
        CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'sales_type_detail','delete');
            return $result;
    }
    //查询售后时间期限
    public static function search_time_limit_all()
    {
            $result = Yii::app()->db->createCommand('SELECT * FROM `sales_type_detail` WHERE is_delete=0')
            ->queryAll();
            return $result;
    }
	 //根据商品型号查询sku
       public static function searchsku_bymodelid($model_id)
       {
       	//echo json_encode($model_id);die;
       	$result = Yii::app()->db
       	->createCommand("SELECT
							a.id as aid,
						GROUP_CONCAT(DISTINCT CONCAT_WS(':',c.name,d.name_value) separator '/') as guige
						FROM
 							goods_sku a 
						LEFT JOIN  goods_property_group b ON a.id=b.goods_sku_id 
						LEFT JOIN goods_property c ON b.goods_property_id=c.id 
						LEFT JOIN goods_property_value d ON b.goods_property_value_id=d.id 
						where a.goods_model_id = :model_id AND a.price1<>0 AND a.is_delete =0 GROUP BY aid")->bindParam(':model_id',$model_id)->queryAll();
       	return $result;
       	
       }
       //根据id查询sku
       public static function searchskus_bymodelid($sku_id)
       {
       	//echo json_encode($model_id);die;
       	$result = Yii::app()->db
       	->createCommand("SELECT
							a.id as aid,
						GROUP_CONCAT(DISTINCT CONCAT_WS(':',c.name,d.name_value) separator '/') as guige
						FROM
 							goods_sku a
						LEFT JOIN  goods_property_group b ON a.id=b.goods_sku_id
						LEFT JOIN goods_property c ON b.goods_property_id=c.id
						LEFT JOIN goods_property_value d ON b.goods_property_value_id=d.id
						where a.id = :sku_id and a.is_delete =0 GROUP BY aid")->bindParam(':sku_id',$sku_id)->queryRow();
       	return $result;
	   }
	    public static function searchmodeladv_Byid($model_id){
       	$result = Yii::app()->db->createCommand("
						SELECT a.id as skuid,a.goods_model_id as goods_model_id,a.price1 as price,e.model_number,
						GROUP_CONCAT(DISTINCT b.name) as name,
						GROUP_CONCAT(DISTINCT c.brandname) as brandname,
						 GROUP_CONCAT(DISTINCT d.images_url)as image_url
						 FROM goods_sku a
						 LEFT JOIN goods_model e ON e.id=a.goods_model_id
						 LEFT JOIN goods b ON e.goods_id=b.id
						 LEFT JOIN brand c ON b.brand=c.id
						 LEFT JOIN adver d ON a.goods_model_id=d.model_id AND d.images_class_id=29
						 WHERE FIND_IN_SET(a.id,:id) GROUP BY a.id")->bindParam(':id',$model_id)->queryAll();
       	return $result;
       }
       public static function searchmodeladvs_Byid($model_id){
       	$result = Yii::app()->db->createCommand("SELECT a.id as id,
					
					GROUP_CONCAT(DISTINCT b.name) as name,
					 GROUP_CONCAT(DISTINCT d.images_url)as image_url
					 FROM goods_model a
					LEFT JOIN goods b ON a.goods_id=b.id
					 LEFT JOIN adver d ON a.id=d.model_id AND d.images_class_id=29
					
					WHERE FIND_IN_SET(a.id,:id) GROUP BY a.id")->bindParam(':id',$model_id)->queryAll();
       	return $result;
       }
       public static function searchbrandjs_Byid($brand_id){
       	$result = Yii::app()->db->createCommand("SELECT id,brandname,img_url FROM brand WHERE FIND_IN_SET(id,:id)")->bindParam(':id',$brand_id)->queryAll();
       	return $result;
       }
       public static function searchjsadv_Byid($adv_id){
       	$result = Yii::app()->db->createCommand("SELECT images_class_id,adressurl,images_url FROM adver WHERE images_class_id=:id")->bindParam(':id',$adv_id)->queryAll();
       	return $result;
       }
       public static function addindex($category,$model,$brandjs,$adverjs,$model_new,$sort){
       	$create_time = date("Y-m-d H:i:s",time());
       	$result = Yii::app()->db->createCommand('INSERT INTO `index_floor`(`category`,`goods`,`brand`,`advert`,`goods_advert`,`sort`,`create_time`)VALUES(:category,:goods,:brand,:advert,:goods_advert,:sort,:create_time)')
       	->bindParam(':category',$category)->bindParam(':goods',$model)->bindParam(':brand',$brandjs)->bindParam(':advert',$adverjs)->bindParam(':goods_advert',$model_new)->bindParam(':sort',$sort)->bindParam(':create_time',$create_time)->execute();
       	return $result;
       }
       public static function editindex($id,$category,$model,$brandjs,$adverjs,$model_new,$sort){
       	$create_time = date("Y-m-d H:i:s",time());
       	$result = Yii::app()->db->createCommand('UPDATE `index_floor` SET category=:category,goods=:goods,brand=:brand,advert=:advert,goods_advert=:goods_advert,sort=:sort,create_time=:create_time WHERE id=:id;')
       	->bindParam(':category',$category)->bindParam(':goods',$model)->bindParam(':brand',$brandjs)->bindParam(':advert',$adverjs)->bindParam(':goods_advert',$model_new)->bindParam(':sort',$sort)->bindParam(':create_time',$create_time)->bindParam(':id',$id)->execute();
       	return $result;
       }
	    public static function searchcates_Byid($id)
       {
       	$result = Yii::app()->db->createCommand('SELECT id,name FROM `goods_classfiy` WHERE id=:id AND is_delete=0')->bindParam(':id',$id)->queryRow();
       	return $result;
       }
	    //通过cateid 查找类别名称
       public static function searchcates_Byids($id)
       {
       	$result = Yii::app()->db->createCommand("SELECT id,name FROM `goods_classfiy` WHERE FIND_IN_SET(id,:id)")->bindParam(':id', $id)->queryAll();
       	return $result;
       }
	   public static function searchCatealls()
       {
       	$result = Yii::app()->db->createCommand("SELECT * FROM `goods_classfiy`  WHERE is_delete=0 and pid=0 ORDER BY sort")->queryAll();
       	return $result;
       }
	   
}






























