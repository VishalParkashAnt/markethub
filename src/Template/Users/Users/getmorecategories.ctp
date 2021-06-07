
             <?php foreach($parent_categories as $cat){
                	$imageurl = SITE_URL.'images/category/'.$cat->category_webimage;
                	?>
              <span id="figcaption_titles" figcaption_title="<?php echo $cat->category_name;?>"></span>
              <span class="figcaption"
                id="figcaption_title_url" figcaption_url="<?php echo $cat->category_urlname;?>"
                style="position: relative; top: 10px; left: 7px;display:none;"><?php echo $cat->category_urlname;?></span><span id="price_vals"
                price_val="$100"></span><a href="<?php echo SITE_URL.'shop/'.$cat->category_urlname;?>" id="user_n"
                usernameval=""><span id="img"
                class="nodisply"><?php echo $imageurl;?></span>
              <div class="product_cnt clearfix col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <div class="bg_product" id="item_cnt97">
                  <img src="<?php echo $imageurl;?>" class="img-responsive">
                </div>
                <div class="prodDescrip new_prod_nam bold-font ">
                  <h3><?php echo $cat->category_name;?></h3>
                  <a href="<?php echo SITE_URL.'shop/'.$cat->category_urlname;?>">See more</a>
                </div>
              </div>
              </a>
          <?php }?>
 