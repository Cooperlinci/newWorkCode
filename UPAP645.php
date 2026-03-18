		<div class="pro_prev_next clean">
			<?php //上一个
			$proid_where=((int)$_SESSION['ly200_user']['UserId']?'1':'IsMember=0')." and SaleOut!=1 and CateId='{$products_row['CateId']}'";
			$prev_where=$proid_where." and ((MyOrder='{$products_row['MyOrder']}' and ProId>'{$products_row['ProId']}')";
			$products_row['MyOrder'] && $prev_where.=" or (MyOrder>0 and MyOrder<'{$products_row['MyOrder']}')";
			($products_row['MyOrder']==-1 || $products_row['MyOrder']==0) && $prev_where.=" or MyOrder>'{$products_row['MyOrder']}'";
			$prev_where.=")";
			$prev_row = db::get_one('products', $prev_where, '*', 'if(MyOrder>0, MyOrder, if(MyOrder=0, 1000000, 1000001)) desc, ProId asc');
			if($prev_row){
			?>
				<a href="<?=web::get_url($prev_row, 'products');?>" title="<?=$prev_row['Name'.$c['lang']]?>" class="prev"></a>
			<?php }?>
			<?php //*下一个
			$next_where=$proid_where." and ((MyOrder='{$products_row['MyOrder']}' and ProId<'{$products_row['ProId']}')";
			$products_row['MyOrder']>0 && $next_where.=" or MyOrder>'{$products_row['MyOrder']}' or MyOrder=0 or MyOrder=-1";
			$products_row['MyOrder']==0 && $next_where.=" or MyOrder=-1";
			$next_where.=")";
			$next_row = db::get_one('products', $next_where, '*', 'if(MyOrder>0, MyOrder, if(MyOrder=0, 1000000, 1000001)) asc, ProId desc');
			if($next_row){
			?>
				<a href="<?=web::get_url($next_row, 'products');?>" title="<?=$next_row['Name'.$c['lang']]?>" class="next"></a>
			<?php }?>
		</div>

        <style>
            .pro_prev_next{line-height:22px; text-align:right;}
            .pro_prev_next a{display:inline-block; width:22px; height:22px; margin:0 2px; background:url(../images/ico/prev_next.png) no-repeat; text-decoration:none; content:'';}
            .pro_prev_next a.prev{background-position:0 0;}
            .pro_prev_next a.next{background-position:-22px 0;}     
        </style>