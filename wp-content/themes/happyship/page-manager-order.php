<?php get_header('secondary'); ?>

	<div class="wrapper">
      <div class="toolbar-wrap filter-block">
        <div class="toolbar-filter">
          <p class="filter-btn custombtn"> Bộ lọc</p>
          <p class="sort-btn custombtn"> Sắp Xếp</p>
        </div>
        <div class="contain-filter" style="display: none;">
          <div class="content-filter">
            
            <input id="" type="radio" name="gender" value="male"/>
            <label for="">Tên shop</label>
            
            <input id="" type="radio" name="gender" value="female"/>
            <label for="">Nhân viên giao hàng</label>
            
            <input id="" type="radio" name="gender" value="other"/>
            <label for="">Trạng thái đơn hàng</label>

            <input id="" type="radio" name="gender" value="other"/>
            <label for="">Quận / huyện </label>
          </div>
          <div class="content-sortby">
            <input id="" type="radio" name="gender" value="male"> Ngày <br>
            <input id="" type="radio" name="gender" value="female"> Tháng <br>
            <input id="" type="radio" name="gender" value="other"> Other
          </div>
        </div>
        <div class="pagnagin-left">
          <ul>
            <li clas="current"><span>1</span></li>
            <li><a href="">2</a></li>
            <li><a href="">3</a></li>
            <li><a href="">4</a></li>
          </ul>
        </div>
      </div>
      <h1>Danh sách đơn hàng trong tháng</h1>
      <hr class="line-up">
		<div class="grid-box-wrap">





        <div class="box-item">
          <div class="box-shop-name"><span>Tên shop:</span>Đặng Thị Hương Mơ</div>
          <div class="shop-info">
            <dl>
              <dt>Điện thoại:</dt>
              <dd>0901492567</dd>
              <dt>Địa chỉ:</dt>
              <dd>93/3 Phùng Tá Chu</dd>
              <dt>Phường:</dt>
              <dd>An Lạc</dd>
              <dt>Quận/huyện:</dt>
              <dd>Q.Tân Bình</dd>
              <dt>Mã xác minh:</dt>
              <dd>0901492567</dd>
            </dl>
          </div>
          <div class="to-info">
            <dl>
              <dt>Đến:</dt>
              <dd>Nguyễn Yến Nhi</dd>
              <dt>Điện thoại:</dt>
              <dd>0901492567</dd>
              <dt>Địa chỉ:</dt>
              <dd>93/3 Phùng Tá Chu</dd>
              <dt>Phường:</dt>
              <dd>An Lạc</dd>
              <dt>Quận/huyện:</dt>
              <dd>Q.Tân Bình</dd>
              <dt>Mã xác minh:</dt>
              <dd>0901492567</dd>
            </dl>
          </div>
          <div class="status"> <span>DH140</span>Đang xử lí</div>
        </div>


      </div>
    </div>
<?php get_footer('secondary'); ?>
    