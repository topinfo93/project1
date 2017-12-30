<?php get_header(); 

if(isset($_GET['logout'])){
	unset($_SESSION['logged']);
}
?>

	<div id="home">
            <div id="da-slider" class="da-slider">
                <div class="mask"></div>
                <div class="container1">
                    <div class="da-slide da-slide1">
                        <!-- <h2 class="fittext2">Welcome to pluton theme</h2>
                        <h4>Clean & responsive</h4>
                        <p>When she reached the first hills of the Italic Mountains, she had a last view back on the skyline of her hometown Bookmarksgrove, the headline of Alphabet Village and the subline of her own road, the Line Lane.</p>
                        <a href="#" class="da-link button">Read more</a> -->
                    </div>
                    <div class="da-slide da-slide2">
                        <!-- <h2>Easy management</h2>
                        <h4>Easy to use</h4>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
                        <a href="#" class="da-link button">Read more</a> -->
                    </div>
                    <div class="da-arrows">
                        <span class="da-arrows-prev"></span>
                        <span class="da-arrows-next"></span>
                    </div>
                </div>
            </div>
        </div>
       
         <!-- About us section start -->
        <div class="section primary-section" id="get-service">
            <div class="container">
                <div class="box-control create-new">
                    <div class="circle-border zoom-in">
                        <a href="<?php echo home_url("member-create-order")?>"><img class="img-circle" src="<?php echo get_template_directory_uri(); ?>/images/Service3.png" alt="service 3"/></a>
                    </div>
                    <div class="title">
                        <p><a href="<?php echo home_url("member-create-order")?>">Tạo đơn hàng</a></p>
                        <p class="des"> Nhấp để tạo đơn hàng </p>
                    </div>
                </div>
                <div class="box-control manager">
                    <div class="circle-border zoom-in">
                        <a href="<?php echo home_url("member-list-order")?>"><img class="img-circle" src="<?php echo get_template_directory_uri(); ?>/images/Service3.png" alt="service 3"/></a>
                    </div>
                    <div class="title">
                        <p><a href="<?php echo home_url("member-list-order")?>">Quản lí đơn hàng</a></p>
                        <p class="des"> Nhấp để xem danh sách, quản lí đơn hàng của bạn </p>
                    </div>
                </div>
                <div class="box-control check">
                    <div class="circle-border zoom-in">
                        <img class="img-circle" src="<?php echo get_template_directory_uri(); ?>/images/Service3.png" alt="service 3"/>
                    </div>
                    <div class="title">
                        <p>Kiểm tra đơn hàng</p>
                        <form action="<?php echo home_url("member-list-order")?>" name="search_order" id="search_order" method="GET">
                            <p class="form-row">
                                <input type="text" name="order-id" id="order-id" placeholder="Nhập mã đơn hàng" value="" />
                                <input type="submit" name="btn_search_order" id="btn_search_order" value="Tìm"/>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Client section start -->

        <div class="section primary-section" id="service">
            <div class="container">
                <!-- Start title section -->
                <div class="title">
                    <h1>Chúng tôi có thể giúp bạn?</h1>
                    <!-- Section's title goes here -->
                    <p>Bạn muốn giao sản phẩm, bưu phẩm cho khách hàng. Bạn không muốn lãng phí thời gian của bạn. Bạn không an tâm về các dịch vụ khác?</p>
                    <!--Simple description for section goes here. -->
                </div>
                <div class="row-fluid">
                    <div class="span4 service-box">
                        <div class="centered service">
                            <div class="circle-border zoom-in">
                                <img class="img-circle" src="<?php echo get_template_directory_uri(); ?>/images/Service1.png" alt="service 1">
                            </div>
                            <h3>Vận Chuyển Hàng</h3>
                            <p>Giúp bạn vận chuyển hàng hóa nhanh nhất có thể</p>
                        </div>
                    </div>
                    <div class="span4 service-box">
                        <div class="centered service">
                            <div class="circle-border zoom-in">
                                <img class="img-circle" src="<?php echo get_template_directory_uri(); ?>/images/Service2.png" alt="service 2" />
                            </div>
                            <h3>Thu phí</h3>
                            <p>Chúng tôi có thể giúp bạn thu phí sau khi vận chuyển hàng hóa</p>
                        </div>
                    </div>
                    <div class="span4 service-box">
                        <div class="centered service ">
                            <div class="circle-border zoom-in">
                                <img class="img-circle" src="<?php echo get_template_directory_uri(); ?>/images/Service3.png" alt="service 3">
                            </div>
                            <h3>Giao/ Nhận Biên lai</h3>
                            <p>Giúp bạn giao biên lại, xác nhận đã giao hàng, thu phí...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
       
        <div id="clients">
            <div class="section primary-section">
                <div class="container">
                    <div class="title">
                        <h1>Đánh giá của khách hàng</h1>
                        <p>Một số đánh giá khách quan của khách hàng sử dụng dịch vụ của chúng tôi</p>
                    </div>
                    <div class="row">
                        <div class="span4">
                            <div class="testimonial">
                                <p>"Thật sự mà nói các bạn làm việc tận tâm, nhanh chóng và hiệu quả"</p>
                                <div class="whopic">
                                    <div class="arrow"></div>
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/Client1.png" class="centered" alt="client 1">
                                    <strong>Anh An
                                        <small>Quận 1, TP.Hồ Chí Minh</small>
                                    </strong>
                                </div>
                            </div>
                        </div>
                        <div class="span4">
                            <div class="testimonial">
                                <p>"Quá nhanh chóng và hài lòng, công việc giao sản phẩm đến khách hàng thật dễ dàng khi có các bạn"</p>
                                <div class="whopic">
                                    <div class="arrow"></div>
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/Client2.png" class="centered" alt="client 2">
                                    <strong>Anh Trung Dũng
                                        <small>Quận Tân Bình, TP.Hồ Chí Minh</small>
                                    </strong>
                                </div>
                            </div>
                        </div>
                        <div class="span4">
                            <div class="testimonial">
                                <p>"Shop không cần nhân viên phải giao hàng, và đóng cửa shop khi đó. Quá thuận tiện và không tốn quá nhiều chi phí.Cám ơn các bạn."</p>
                                <div class="whopic">
                                    <div class="arrow"></div>
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/Client3.png" class="centered" alt="client 3">
                                    <strong>Chị Linh Chi
                                        <small>Quận 3, TP.Hồ Chí Minh</small>
                                    </strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="section third-section">
            <div class="container centered ">
                <div class="row-fluid">
                    <div class="span6">
                        <div class="highlighted-box center">
                            <h1>Chúng tôi đang tuyển dụng</h1>
                            <p>Với tiêu chí phục vụ khách hàng tối đa, nhanh chóng. Đến nhận/ giao hàng mọi lúc mọi nơi trong thành phố Hồ Chí Minh và vùng lân cận.Nên chúng tôi cần những người tận tụy. Hãy liên lạc với chúng tôi. Nếu bạn muốn gia nhập đội ngũ Happy ship!</p>
                            <button class="button button-sp">Nộp đơn</button>
                        </div>
                    </div>
                    <div class="span6 sub-section">
                        <div class="title clearfix">
                            <div class="pull-left">
                                <h3>Tuyển dụng</h3>
                            </div>
                            <ul class="client-nav pull-right">
                                <li id="client-prev"></li>
                                <li id="client-next"></li>
                            </ul>
                        </div>
                        <ul class="row client-slider" id="clint-slider">
                            <li>
                                <a href="">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/clients/ClientLogo01.png" alt="client logo 1">
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/clients/ClientLogo02.png" alt="client logo 2">
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/clients/ClientLogo03.png" alt="client logo 3">
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/clients/ClientLogo04.png" alt="client logo 4">
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/clients/ClientLogo05.png" alt="client logo 5">
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/clients/ClientLogo02.png" alt="client logo 6">
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/clients/ClientLogo04.png" alt="client logo 7">
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                

            </div>
        </div>
        <!-- Price section start -->
        <div id="price" class="section secondary-section">
            <div class="container">
                <div class="title">
                    <h1>Bảng giá dịch vụ</h1>
                    <p>Giá cả cạnh tranh trên thị trường, dưới đây là bảng giá chi tiết tham khảo :</p>
                </div>
                <div class="price-table row-fluid">
                    <div class="span3 price-column">
                        <h3> 15.000 đ</h3>
                        <div class="price-box price-column-1">
                        </div>
                    </div>
                    <div class="span3 price-column">
                        <h3> 15.000 đ</h3>
                        <div class="price-box price-column-2">
                        </div>
                    </div>
                    <div class="span3 price-column">
                        <h3> 15.000 đ</h3>
                        <div class="price-box price-column-3">
                        </div>
                    </div>
                    <div class="span3 price-column">
                        <h3> 15.000 đ</h3>
                        <div class="price-box price-column-4">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Price section end -->
<?php get_footer(); ?>