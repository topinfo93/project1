<?php
add_action("admin_menu", "addMenu");

function addMenu(){
    add_menu_page("Shipping Manager","Shipping Manager",4, "shipping-manager","shippingManager" );
}

function shippingManager() { 
    global $wpdb;
    if (isset($_GET['edit']) && $_GET['edit'] != null ) { 
     edit();
    }else if (isset($_GET['update_ordered']) && $_GET['update_ordered'] != null) {
        update_ordered();
    }else if (isset($_GET['delete_order']) && $_GET['delete_order'] != null) {
        delete_order();
    }else if (isset($_GET['update']) && $_GET['update'] != null) {
        update();
    }else if (isset($_GET['list_order']) && $_GET['list_order'] != null) {
     list_order();
    }else if (isset($_GET['list_price']) && $_GET['list_price'] != null) {
     list_price();  
    }else if (isset($_GET['edit_order']) && $_GET['edit_order'] != null) {
     edit_order();
    }else{ 
        dashboard();
        // tạo danh sách    
        // $array = array("Quan-1","Quan-2","Quan-3","Quan-4","Quan-5","Quan-6","Quan-7","Quan-8","Quan-9","Quan-10","Quan-11","Quan-12","Quan-Thu-Duc","Quan-Go-Vap","Quan-Binh-Thanh","Quan-Tan-Phu","Quan-Tan-Binh","Quan-Phu-Nhuan","Quan-Binh-Tan","Huyen-Binh-Chanh","Huyen-Can-Gio","Huyen-Cu-Chi","Huyen-Hoc-Mon","Huyen-Nha-Be");
        // foreach ($array as $key) {
        //     foreach ($array as $key2) {
        //      $wpdb->query("INSERT INTO `wp_price_manager` (`id`, `nhan_hang`, `giao_hang`, `gia_tiet_kiem`, `gia_nhanh`,`super_happy`) VALUES (NULL, '".$key."', '".$key2."', '0', '0', '0')");
        //     }
        // }
    } 
} 

function dashboard(){ ?>
    <div class="container">
        <div class="row">
        <?php// echo date("m/d/Y h:i:s a", time()); ?>


        <div class="form-group">
            <button type="button" class="btn btn-primary"> 
                <a style="color: #fff" href="<?php  menu_page_url('shipping-manager'); ?>&list_price=1">Quán lý giá vận chuyển</a>
            </button>
        </div>

        <div class="form-group">
            <button type="button" class="btn btn-success"> 
                <a style="color: #fff" href="<?php  menu_page_url('shipping-manager'); ?>&list_order=1">Quán lý đơn hàng</a>
            </button>
        </div>
            

        </div>
    </div>

<?php } 

function edit() {
    global $wpdb;
    $results = $wpdb->get_results( 'SELECT * FROM wp_price_manager WHERE id = '.$_GET["edit"].'' , OBJECT );
        ?>
<div class="happy-edit">
    <div class="container">
        <h2>Chỉnh sửa thông tin</h2>
        <form method="post" action="<?php  menu_page_url('shipping-manager'); ?>&update=<?php echo $results[0]->id; ?>">
            <div class="form-group">
                <label for="email">Điểm nhận hàng:</label><br>
                <input type="text" class="form-control" disabled="" value="<?php echo $results[0]->nhan_hang; ?>">
            </div>
            <div class="form-group">
                <label for="pwd">Điểm giao hàng:</label> <br>
                <input type="text" class="form-control" disabled="" value="<?php echo $results[0]->giao_hang; ?>">
            </div>
            <div class="clearfix"></div>
            <div class="form-group">
                <label for="pwd">Giá tiết kiệm:</label> <br>
                <input type="number" class="form-control" value="<?php echo $results[0]->gia_tiet_kiem; ?>" name="gia_tiet_kiem">
            </div>
            <div class="clearfix"></div>
            <div class="form-group">
                <label for="pwd">Giá nhanh:</label> <br>
                <input type="number" class="form-control" value="<?php echo $results[0]->gia_nhanh; ?>" name="gia_nhanh">
            </div>
            <div class="clearfix"></div>
            <div class="form-group">
                <label for="pwd">Supper happy:</label> <br>
                <input type="number" class="form-control" value="<?php echo $results[0]->super_happy; ?>" name="super_happy">
            </div>
            <div class="clearfix"></div>
            <div class="form-group">
                <button type="submit" class="btn btn-default">Submit</button>
            </div>
            
        </form>
    </div>
</div>
<?php }
function update_ordered() { 
    global $wpdb;
    $trang_thai = $_POST['trang_thai'];
    $id = $_GET['update_ordered'];
    $wpdb->query("UPDATE `wp_ordered_manager` SET `trang_thai` = '".$trang_thai."' WHERE `wp_ordered_manager`.`id` = $id;");
    ?>

    <p>Cập nhật thành công</p>
    <br>
    <a href="<?php  menu_page_url('shipping-manager'); ?>&list_order=1"><button>Back</button></a>
    <!-- delete ordered -->
<?php }
function deleted_order() {

}

function delete_order() {
    global $wpdb,$menu_plugin_url; 
    $id = $_GET['id'];
    $confirm = $_GET['delete_order'];

    if($confirm == 'yes' && $id != '' && $id != null){

         $deleted = $wpdb->query("DELETE FROM `wp_ordered_manager` WHERE `wp_ordered_manager`.`id` = ".$id.";");

         if ($deleted == 1) { ?>

        <p>Đơn hàng được xóa thành công !</p>

         <?php }

    }elseif($confirm == 'confirm'){ ?>

        <p>Bạn có chắc chắn muốn xóa đơn hàng này không?</p>
        <br>
        <a href="<?php  menu_page_url('shipping-manager'); ?>&delete_order=yes&id=<?php echo $id; ?>"><button>Đồng ý</button></a>
        <a href="<?php  menu_page_url('shipping-manager'); ?>&list_order=1"><button>Quay lại</button></a>

    <?php 
    }
}
function update() { 
    global $wpdb;

    $gia_nhanh = $_POST['gia_nhanh'];
    $gia_tiet_kiem = $_POST['gia_tiet_kiem'];
    $super_happy = $_POST['super_happy'];
    $id = $_GET['update'];

    $updated = $wpdb->query("UPDATE `wp_price_manager` SET  `gia_tiet_kiem` = $gia_tiet_kiem,`gia_nhanh` = $gia_nhanh, `super_happy` = $super_happy WHERE `wp_price_manager`.`id` = $id;");
    ?>
    <?php var_dump($updated); ?>
    <p>Cập nhật thành công</p>
    <br>
    <a href="<?php  menu_page_url('shipping-manager'); ?>"><button>Quay lại</button></a>
<?php }
function list_price(){ 
    global $wpdb; ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-default"> <a href="<?php  menu_page_url('shipping-manager'); ?>">Quay lại</a></button>
            </div>

        <div class="col-md-12">
            <div>Giá dưới đây chỉ áp dụng cho kích thước hàng dưới 50cm3 và trọng lượng dưới 2kg</div>
        </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Điểm nhận hàng</th>
                        <th>Điểm giao hàng</th>
                        <th>Giá tiết kiệm</th>
                        <th>Giá nhanh</th>
                        <th>Super Happy</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $results = $wpdb->get_results( 'SELECT * FROM wp_price_manager', OBJECT ); 
                        foreach ($results as $key) { ?>
                    <tr>
                        <td>#<?php echo $key->id; ?></td>
                        <td><?php echo $key->nhan_hang; ?></td>
                        <td><?php echo $key->giao_hang; ?></td>
                        <td><?php echo $key->gia_tiet_kiem; ?></td>
                        <td><?php echo $key->gia_nhanh; ?></td>
                        <td><?php echo $key->super_happy; ?></td>
                        <td><a href="<?php  menu_page_url('shipping-manager'); ?>&edit=<?php echo $key->id; ?>">Edit</a></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

<?php }

function edit_order(){

    global $wpdb;
    $results = $wpdb->get_results( 'SELECT * FROM wp_ordered_manager WHERE id = '.$_GET["edit_order"].'' , OBJECT );
    ?>

    <div class="happy-edit">
        <div class="container">
            <div class="jumbotron">
                <h1>Chỉnh sửa thông tin đơn hàng</h1> 
            </div>
            <form method="post" action="<?php  menu_page_url('shipping-manager'); ?>&update_ordered=<?php echo $results[0]->id; ?>">
                <div class="form-group">
                    <label for="email">Tên người nhận:</label><br>
                    <input type="text" class="form-control" disabled="" value="<?php echo $results[0]->nguoi_nhan; ?>">
                </div>
                <div class="form-group">
                    <label for="pwd">Số điện thoại:</label> <br>
                    <input type="text" class="form-control" disabled="" value="<?php echo $results[0]->sdt_nguoi_nhan; ?>">
                </div>
                <div class="form-group">
                    <label for="email">Địa chỉ nhận hàng:</label><br>
                    <input type="text" class="form-control" disabled="" value="<?php echo $results[0]->dia_chi_nguoi_nhan; ?>">
                </div>
                <div class="form-group">
                    <label for="pwd">Quận/Huyện:</label> <br>
                    <input type="text" class="form-control" disabled="" value="<?php echo $results[0]->quan_huyen_nhan; ?>">
                </div>
                <div class="form-group">
                    <label for="email">Phường:</label><br>
                    <input type="text" class="form-control" disabled="" value="<?php echo $results[0]->phuong_nhan; ?>">
                </div>
                <div class="form-group">
                    <label for="pwd">Tên hàng hóa + ghi chú:</label> <br>
                    <input type="text" class="form-control" disabled="" value="<?php echo $results[0]->ten_hang; ?>">
                </div>
                <div class="form-group">
                    <label for="pwd">Khối lượng (kg):</label> <br>
                    <input type="text" class="form-control" disabled="" value="<?php echo $results[0]->khoi_luong; ?>">
                </div>
                <div class="form-group">
                    <label for="pwd">Tiền thu hộ (đ):</label> <br>
                    <input type="text" class="form-control" disabled="" value="<?php echo $results[0]->thu_ho; ?>">
                </div>
                <div class="form-group">
                    <label for="pwd">Gói dịch vụ:</label> <br>
                    <input type="text" class="form-control" disabled="" value="<?php echo $results[0]->goi_dv; ?>">
                </div>
                <div class="form-group">
                    <label for="pwd">Tên shop:</label> <br>
                    <input type="text" class="form-control" disabled="" value="<?php echo $results[0]->ten_shop; ?>">
                </div>
                <div class="form-group">
                    <label for="pwd">Số điện thoại shop:</label> <br>
                    <input type="text" class="form-control" disabled="" value="<?php echo $results[0]->sdt_shop; ?>">
                </div>
                <div class="form-group">
                    <label for="pwd">Địa chỉ shop:</label> <br>
                    <input type="text" class="form-control" disabled="" value="<?php echo $results[0]->dia_chi_shop; ?>">
                </div>
                <div class="form-group">
                    <label for="pwd">Quận/Huyện(shop):</label> <br>
                    <input type="text" class="form-control" disabled="" value="<?php echo $results[0]->quan_huyen_shop; ?>">
                </div>
                <div class="form-group">
                    <label for="pwd">Phường(shop):</label> <br>
                    <input type="text" class="form-control" disabled="" value="<?php echo $results[0]->phuong_shop; ?>">
                </div>
                <div class="form-group">
                    <label for="pwd">Ngày tạo</label> <br>
                    <input disabled type="text" class="form-control" disabled="" value="<?php echo $results[0]->ngay_tao_don; ?>">
                </div>
                <div class="form-group">
                    <label for="pwd">Ngày sửa đổi</label> <br>
                    <input disabled type="text" class="form-control" disabled="" value="<?php echo $results[0]->ngay_sua_don; ?>">
                </div>
                <div class="form-group">
                    <label for="pwd">Trạng thái:</label> <br>
                    <select class="form-control" name="trang_thai">

                        <option value="lan-1">Đang giao hàng lần 1</option>
                        <option value="lan-2">Đang giao hàng lần 2</option>
                        <option value="lan-3">Đang giao hàng lần 3</option>
                        <option value="huy">Đơn hàng hủy</option>
                        <option value="thanh-cong">Giao thành công</option>
                        <option value="cod">Đã thanh toán COD</option>



                       
                    </select>
                </div>
                
                <div class="clearfix"></div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-success">Xác nhận</button>
            </div>

            </form>
        </div>
    </div>
<?php }
function list_order(){
    global $wpdb;
    ?>

    <div class="container">
        <div class="row">


        <div class="form-group">
            <button type="button" class="btn btn-primary"> 
                <a style="color: #fff" href="<?php  menu_page_url('shipping-manager'); ?>">Quay lại</a>
            </button>
        </div>

            <h2>Danh sách đơn hàng</h2>
            <div class="col-md-12">
                <?php 
                    $wpdb->get_results( 'SELECT * FROM wp_ordered_manager' , OBJECT );
                    $total_records = $wpdb->num_rows;
                    
                    $current_page = isset($_GET['pagination']) ? $_GET['pagination'] : 1; 
                    $limit = 12;
                    
                    $total_page = ceil($total_records / $limit);
                    
                    
                    if ($current_page > $total_page){
                        $current_page = $total_page;
                    }
                    else if ($current_page < 1){
                        $current_page = 1;
                    }
                    
                    $start = ($current_page - 1) * $limit;
                    
                    $results = $wpdb->get_results( "SELECT * FROM wp_ordered_manager LIMIT $start, $limit" , OBJECT );
                    
                    
                    if ($current_page > 1 && $total_page > 1){
                        echo '<a href="'.menu_page_url('shipping-manager').'&list_order=1&pagination='.($current_page-1).'">Prev</a> | ';
                    }
                    
                    for ($i = 1; $i <= $total_page; $i++){
                        if ($i == $current_page){
                            echo '<span>'.$i.'</span> | ';
                        }
                        else{
                            echo '<a href="'.menu_page_url('shipping-manager').'&list_order=1&pagination='.$i.'">'.$i.'</a> | ';
                        }
                    }
                    
                    if ($current_page < $total_page && $total_page > 1){
                        echo '<a href="'.menu_page_url('shipping-manager').'&list_order=1&pagination='.($current_page+1).'">Next</a> | ';
                    } ?>
            </div>
            <div class="col-md-12">
                <?php foreach ($results as $key) { ?>
                <div class="box-item">
                    <div class="wrap-shop">
                        <div class="shop">
                            <div class="left">ID</div>
                            <div class="right">HS<?php echo $key->id; ?></div>
                            <div class="clearfix" style="clear:both;"></div>
                        </div>
                    </div>
                    <div class="wrap-client">
                        <div class="client" style="height: 50px;">
                            <div class="left">Tên</div>
                            <div class="right"><?php echo $key->nguoi_nhan; ?></div>
                            <div class="clearfix" style="clear:both;"></div>
                        </div>
                        <div class="client">
                            <div class="left">SĐT</div>
                            <div class="right"><?php echo $key->sdt_nguoi_nhan; ?></div>
                            <div class="clearfix" style="clear:both;"></div>
                        </div>
                        <div class="client" style="height: 60px">
                            <div class="left">Đ/C</div>
                            <div class="right"><?php echo $key->dia_chi_nguoi_nhan; ?></div>
                            <div class="clearfix" style="clear:both;"></div>
                        </div>
                        <div class="client">
                            <div class="left">Phường</div>
                            <div class="right"><?php echo $key->phuong_nhan; ?></div>
                            <div class="clearfix" style="clear:both;"></div>
                        </div>
                        <div class="client">
                            <div class="left">Quận/huyện</div>
                            <div class="right"><?php echo $key->quan_huyen_nhan; ?></div>
                            <div class="clearfix" style="clear:both;"></div>
                        </div>
                        <div class="client">
                            <div class="left">Tên hàng</div>
                            <div class="right"><?php echo $key->ten_hang; ?></div>
                            <div class="clearfix" style="clear:both;"></div>
                        </div>
                        <div class="client">
                            <div class="left">Khối lượng</div>
                            <div class="right"><?php echo $key->khoi_luong; ?></div>
                            <div class="clearfix" style="clear:both;"></div>
                        </div>
                        <div class="client">
                            <div class="left">Tiền thu hộ</div>
                            <div class="right"><?php echo $key->thu_ho; ?></div>
                            <div class="clearfix" style="clear:both;"></div>
                        </div>
                        <div class="client">
                            <div class="left">Gói</div>
                            <div class="right"><?php echo $key->goi_dv; ?></div>
                            <div class="clearfix" style="clear:both;"></div>
                        </div>
                        <div class="clearfix" style="clear:both;"></div>
                    </div>
                    <div class="wrap-shop">
                        <div class="shop">
                            <div class="left">Tên Shop</div>
                            <div class="right"><?php echo $key->ten_shop; ?></div>
                            <div class="clearfix" style="clear:both;"></div>
                        </div>
                        <div class="shop">
                            <div class="left">SĐT Shop</div>
                            <div class="right"><?php echo $key->sdt_shop; ?></div>
                            <div class="clearfix" style="clear:both;"></div>
                        </div>
                        <div class="shop">
                            <div class="left">Đ/C</div>
                            <div class="right"><?php echo $key->dia_chi_shop; ?></div>
                            <div class="clearfix" style="clear:both;"></div>
                        </div>
                        <div class="shop">
                            <div class="left">Phường</div>
                            <div class="right"><?php echo $key->phuong_shop; ?></div>
                            <div class="clearfix" style="clear:both;"></div>
                        </div>
                        <div class="shop">
                            <div class="left">Quận/huyện</div>
                            <div class="right"><?php echo $key->quan_huyen_shop; ?></div>
                            <div class="clearfix" style="clear:both;"></div>
                        </div>
                        <div class="shop">
                            <div class="left">Mã xác minh</div>
                            <div class="right"><?php echo $key->pass; ?></div>
                            <div class="clearfix" style="clear:both;"></div>
                        </div>
                        <div class="clearfix" style="clear:both;"></div>
                    </div>
                    <div class="wrap-status">
                        <div class="left">Trạng thái</div>
                        <div class="right"><?php echo $key->trang_thai; ?></div>
                        <div class="clearfix" style="clear:both;"></div>
                    </div>
                    <div class="wrap-action">
                        <div class="left"><a href="<?php  menu_page_url('shipping-manager'); ?>&edit_order=<?php echo $key->id; ?>">Edit</a></div>
                        <div class="right"><a href="<?php  menu_page_url('shipping-manager'); ?>&delete_order=confirm&id=<?php echo $key->id; ?>">Delete</a></div>
                        <div class="clearfix" style="clear:both;"></div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php 
} ?>