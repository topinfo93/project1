<header class="clearfix">
      <div id="logo">
        <img src="<?php echo get_template_directory_uri(); ?>/images/logo.png">
      </div>
      <div id="company">
        <h2 class="name">CÔNG TY TNHH GIAO HÀNG HẠNH PHÚC</h2>
        <div>254/54/1 Dương Quảng Hàm, P5, Gò Vấp</div>
        <div>0909.070.935</div>
        <div><a href="mailto:happyshipad@gmail.com">happyshipad@gmail.com</a></div>
      </div>
      </div>
    </header>
    <main>
      <div id="details" class="clearfix">
        <div id="client">
          <div class="to">Người nhận:</div>
          <h2 class="name"><?php echo (get_post_meta(get_the_ID(), 'name', true)); ?></h2>
          <div class="address">Đ/c: <?php echo (get_post_meta(get_the_ID(), 'address', true)); ?>- <?php echo (get_post_meta(get_the_ID(), 'district', true)); ?></div>
           <div class="phone">Sđt: <?php echo (get_post_meta(get_the_ID(), 'phone', true)); ?></div>
        </div>
        <div id="invoice">
          <h1>HAPPY-<?php the_ID(); ?> </h1>
          <div class="date">Ngày tạo đơn: <?php echo get_the_date( 'd/m/Y', get_the_ID() ); ?></div>
          
        </div>
      </div>
      <table border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th class="no"></th>
            <th class="desc">NỘI DUNG</th>
            <th class="unit">KHỐI LƯỢNG</th>
            <th class="desc">TIỀN THU HỘ</th>
            <th class="unit">GÓI DỊCH VỤ</th>
          </tr>
        </thead>
        <tbody>
        

          <tr>
            <td class="no"></td>
            <td class="desc"><?php the_title(); ?></td>
            <td class="unit"><?php echo (get_post_meta(get_the_ID(), 'weight', true)); ?> kg</td>
            <td class="desc"><?php echo number_format(get_post_meta(get_the_ID(), 'fund', true)); ?> đ</td>
            <td class="unit"><?php echo (get_post_meta(get_the_ID(), 'package', true)); ?></td>
          </tr>

          
        </tbody>
        <tfoot>
          <tr>
            <td colspan="2"></td>
            <td colspan="2">Tiền thu hộ</td>
            <td><?php echo number_format(get_post_meta(get_the_ID(), 'fund', true)); ?> đ</td>
          </tr>
          <tr>
            <td colspan="2"></td>
            <td colspan="2">Phí giao hàng</td>
            <td><?php echo number_format(get_post_meta(get_the_ID(), 'fee', true)); ?> đ</td>
          </tr>
          <tr>
            <td colspan="2"></td>
            <td colspan="2">Tổng tiền</td>
            <td><?php echo number_format(get_post_meta(get_the_ID(), 'fee', true) + get_post_meta(get_the_ID(), 'fund', true)); ?></td>
          </tr>
        </tfoot>
      </table>
      <div id="thanks">Cảm ơn quý khách đã sử dụng dịch vụ của chúng tôi!</div>
      <div id="notices">
        <div>Ghi chú:</div>
        <div class="notice"><?php echo (get_post_meta(get_the_ID(), 'note', true)); ?></div>
      </div>
    </main>