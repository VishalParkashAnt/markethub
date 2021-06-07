<!-- <section class="side-collapse-container"> -->
    <!--Stick floating div code-->
   <!--  <section class="container-fluid no-hor-padding sticker-cnt" style="display: none;">
      <div id="sticker">
        <a href="">
          <div class="active-view default_view bold-font">Default View</div>
        </a>
      </div>
      <div id="sticker">
        <a href="http://services.hitasoft.in/dev/stratus/homepage.html">
          <div class="normal_view custom_view bold-font">custom view</div>
        </a>
      </div>
    </section> -->
    <!--E O Stick floating div code-->
 <!--  </section> -->
 <script type="text/javascript">
     var limit=15;
    var offset=15;
 </script>
  <input type="hidden" id="languagecode" value="">
  <section class="container-fluid side-collapse-container fullPage allcatpge" style="margin-top: 20px;">

    <div class="row">
      <section class="col-md-9 col-sm-12 no-hor-padding ">
        <section class="side-collapse-container mainPage">
          <section class="clearfix">
            <section class="breadcrumb breadCrumb col-xs-12 col-sm-12 col-md-12 col-lg-12 margin-bottom10">
              <div class="breadcrumb">
                 <a href="<?php echo SITE_URL;?>">Home</a>
  <span class="breadcrumb-divider1">/</span>
  <a href="#" style="text-transform:capitalize;" id="changecatname">Categories</a>
              </div>
          </section>
            <h4 class="title">Categories</h4>
            <div class="allImg categorie" id="loadmorecat">
            
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
             
        
            </div>

           <a href="javascript:void(0);" onclick="loadmorecat()" id="loadmore_btn" style="display:<?php echo $show_loadmore;?>;"
               > <div class="loadMore seeallcat btn primary-color-bg primary-color-bg deals" >Load More</div></a>
          </section>

        </section>
      </section>
      <section class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
 
      </section>
    </div>
  </section>
  <script>
    function loadmorecat(){
    limit;
    offset;
  
    var baseurl = getBaseURL()+"getmorecategories";
    $.ajax({
      url: baseurl,
      type: "post",
      data: {limit : limit, offset:offset},
      dataType: "html",
      beforeSend: function () {
        
  },
  success: function(response){
    //alert(response);
    if($.trim(response) != ""){
        $("#loadmorecat").append(response);
        offset=offset+limit;
    }
    else{
      //console.log("empty");
    
      $("#loadmore_btn").hide();
   
    }
    
  }
});
    }
    
  </script>