<?php /* Template Name: Page_service_boking */ ?>
<!--Load Preloader-->

<div id="preloader">
    <h4 id="loading-text">Live L&D is loading your session
        <span class="dot-container">
            <span class="dot-animation">.</span>
            <span class="dot-animation">.</span>
            <span class="dot-animation">.</span>
            <span class="dot-animation">.</span>
        </span>
    </h4>
</div>

<script>
    document.body.classList.add("preloader-active");
</script>
<style>
    body.preloader-active {
        overflow: hidden;
    }

    #preloader {
        display: flex;
        /* Add flexbox to the preloader */
        align-items: center;
        /* Center the loading text vertically */
        justify-content: center;
        /* Center the loading text horizontally */
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: black;
        z-index: 9999;
    }

    #loading-text {
        font-size: 24px !important;
        font-weight: bold !important;
        text-align: center !important;
        white-space: nowrap;
        letter-spacing: 0.15em !important;
        color: #ff8250;
        position: relative;
        /* Change position to relative */
    }

    .dot-container {
        display: inline-flex;
        position: absolute;
        top: 0;
        left: 100%;
        margin-left: 5px;
        width: 50px;
        /* Add a fixed width */
        height: 24px;
        /* Add a fixed height */
    }

    .dot-animation {
        position: absolute;
        animation: dot-bounce 1.2s linear infinite;
        margin-left: 2px;
        will-change: transform;
    }

    .dot-animation:nth-child(2) {
        margin-left: 14px;
        animation-delay: 0.2s;
    }

    .dot-animation:nth-child(3) {
        margin-left: 26px;
        animation-delay: 0.4s;
    }

    .dot-animation:nth-child(4) {
        margin-left: 38px;
        animation-delay: 0.6s;
    }

    @keyframes dot-bounce {

        0%,
        80%,
        100% {
            transform: translateY(0);
        }

        40% {
            transform: translateY(-10px);
        }
    }

    @media only screen and (max-width: 768px) {
        #loading-text {
            font-size: 13px !important;
        }
    }
</style>

<?php
$server_name = "";
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
    $server_name = "https://";
else
    $server_name = "http://";

// Append the host(server name) to the URL.   
$server_name .= $_SERVER['SERVER_NAME'];

// Output the final server name   

$tbprefix = "";
$tbprefix = $wpdb->prefix;
$tbprefix  = trim($tbprefix);


//$servicetitle = $_GET['sname'];;

//$servicetitle = $wpdb->get_results("SELECT * FROM $tbprefix"."amelia_services where name='$servicetitle'");
//$serviceid = $servicetitle[0]->id;

//$serviceid = $_GET['sid'];

$serviceid = get_query_var('sid');


$homepageurl = $server_name . "/expert-home/?id=" . $serviceid;
$service = $wpdb->get_results("SELECT * FROM $tbprefix" . "amelia_services where id='$serviceid'");

//$preTalkId = $service[0]->preTalkSessionId;


$sessionId = $serviceid;


// Get the user ID of the employee associated with the current service ID
$employee_user_id = $wpdb->get_var("SELECT userId FROM {$tbprefix}amelia_providers_to_services WHERE serviceId = {$serviceid}");

// Find the pre-talk session ID by checking the same employee in category 45
$preTalkId = $wpdb->get_var("SELECT aserv.id FROM {$tbprefix}amelia_services as aserv
    INNER JOIN {$tbprefix}amelia_providers_to_services as aps ON aserv.id = aps.serviceId
    WHERE aserv.categoryId = 45 AND aps.userId = {$employee_user_id}");





$catgoryid = $service[0]->categoryId;
global $servicename;
$servicename = $service[0]->name;
$servicedes = $service[0]->description;

$words = explode(" ", $servicedes); // Split the string into an array of words
$limited_words = array_slice($words, 0, 35); // Extract the first 35 words from the array
$limited_string = implode(" ", $limited_words);

function custom_meta_tags($limited_string)
{
    echo '<meta name="description" content="' . $limited_string . '">';
}

add_action('wp_head', 'custom_meta_tags');
do_action('wp_head', $limited_string);


function custom_meta_tags1($servicename)
{
    echo '<title>' . $servicename . '</title>';

    echo '<meta name="title" content="' . $servicename . '">';
    echo '<meta name="og:title" content="' . $servicename . '">';
}

add_action('wp_head', 'custom_meta_tags1');

do_action('wp_head', $servicename);
get_header();


?>



<!-- fuction to get custom image sizes -->

<?php echo '<script type="text/javascript">let kdSingeSession = true; </script>'; ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">


<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Allura&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        background: white;
    }

    div#primary {
        background: white;
        padding-top: 1px;
    }
</style>
<?php





// echo $catgoryid;

$employee =  $wpdb->get_results("SELECT $tbprefix" . "amelia_users.* FROM " . $tbprefix . "amelia_services inner join " . $tbprefix . "amelia_providers_to_services inner join " . $tbprefix . "amelia_users on " . $tbprefix . "amelia_services.id=" . $tbprefix . "amelia_providers_to_services.serviceId and " . $tbprefix . "amelia_providers_to_services.userId=" . $tbprefix . "amelia_users.id where " . $tbprefix . "amelia_services.id='$serviceid'");
$empid = $employee[0]->id;

$externalid = $employee[0]->externalId;

$worduser = 'user_' . $externalid;
?>
<main>
    <?php
    if (get_field('inactive', $worduser)) {
    ?>
        <h1 class="disableuser">This user is Inactive</h1>
    <?php } else {


    ?>
        <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main">
                <div class="container-fluid">
                    <h1 class="pge-title">

                    </h1>
                    <?php
                    $videourl = "https://www.youtube.com/embed/" . $service[0]->video . "?controls=1&showinfo=0&rel=0&loop=1&start=8&autoplay=1&mute=1";
                    ?>

                    <?php
                    $video = $service[0]->video;
                    if ($video != "") {
                    ?>
                        <div class="data-component-video" style="width:100%;margin:0 auto; border: 1px solid #5d395a;">

                            <iframe width="100%" height="600px" src=<?php echo $videourl; ?>>
                            </iframe>

                        </div>

                    <?php
                    } else {
                    ?>
                        <div class="expertimg desktop">
                            <img class="" src=<?php echo $employee[0]->pictureFullPath ?>>
                        </div>
                    <?php
                    }
                    ?>

                    <?php
                    if ($employee[0]->trustedbrand1 != null) {
                    ?>
                        <div class="mainbody logosec">
                            <div class="subrow">
                                <div class="row">
                                    <div class="ab-title tb">Trusted by</div>

                                </div>

                                <div class="row brands">
                                    <div class="row">
                                        <?php
                                        if ($employee[0]->trustedbrand1 != null) {
                                        ?>
                                            <div class="col-md-2">
                                                <img src=<?php echo $employee[0]->trustedbrand1 ?> style="">
                                            </div>
                                        <?php
                                        }
                                        ?>

                                        <?php
                                        if ($employee[0]->trustedbrand2 != null) {
                                        ?>
                                            <div class="col-md-2">
                                                <img src=<?php echo $employee[0]->trustedbrand2 ?> style="">
                                            </div>
                                        <?php
                                        }
                                        ?>

                                        <?php
                                        if ($employee[0]->trustedbrand3 != null) {
                                        ?>
                                            <div class="col-md-2">
                                                <img src=<?php echo $employee[0]->trustedbrand3 ?> style="">
                                            </div>
                                        <?php
                                        }
                                        ?>
                                        <?php
                                        if ($employee[0]->trustedbrand4 != null) {
                                        ?>
                                            <div class="col-md-2">
                                                <img src=<?php echo $employee[0]->trustedbrand4 ?> style="">
                                            </div>
                                        <?php
                                        }
                                        ?>
                                        <?php
                                        if ($employee[0]->trustedbrand5 != null) {
                                        ?>
                                            <div class="col-md-2">
                                                <img src=<?php echo $employee[0]->trustedbrand5 ?> style="">
                                            </div>
                                        <?php
                                        }
                                        ?>



                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php } ?>

                    <div class="row secondtext">
                        <div class="row">

                            <div class="col-md-6 bookwidgetfirtcol">
                                <div class="innerrow">
                                    <div class="row">
                                        <?php

                                        $wordpressuserid = $employee[0]->externalId;
                                        $worduser = 'user_' . $wordpressuserid;
                                        ?>

                                        <h2><?php echo $service[0]->name; ?></h2>
                                        <h3 class="empname"><?php echo $employee[0]->firstName . " " . $employee[0]->lastName; ?>
                                        </h3>

                                        <?php if (get_field('verifed', $worduser)) :

                                        ?>


                                            <span><img src="<?php echo $server_name . "/wp-content/uploads/2023/01/Vector-Stroke.png" ?>"></span>
                                            <p class="verified"><?php the_field('verifed', $worduser); ?></p>
                                        <?php endif; ?>

                                        <div class="row">
                                            <div class="rate">
                                                <?php
                                                $empfullname = $employee[0]->full_name;
                                                $average = 0;
                                                $rate = 0;
                                                $reviewresult = $wpdb->get_results("SELECT * FROM `review_details` where user='$empfullname'");
                                                foreach ($reviewresult as $row) {
                                                    $count = count($reviewresult);
                                                    $review = $row->starreview;

                                                    $rate += $review;
                                                    $average = $rate / $count;
                                                }
                                                $rating = round($average);
                                                if ($rating == "1") {
                                                ?>
                                                    <img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2022/09/star-3-1.png" ?>">
                                                    <img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2022/10/emptystar.png" ?>">
                                                    <img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2022/10/emptystar.png" ?>">
                                                    <img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2022/10/emptystar.png" ?>">
                                                    <img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2022/10/emptystar.png" ?>">


                                                <?php
                                                } else if ($rating == "2") {
                                                ?>
                                                    <img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2022/09/star-3-1.png" ?>">
                                                    <img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2022/09/star-3-1.png" ?>">
                                                    <img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2022/10/emptystar.png" ?>">
                                                    <img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2022/10/emptystar.png" ?>">
                                                    <img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2022/10/emptystar.png" ?>">
                                                <?php
                                                } else if ($rating == "3") {
                                                ?>
                                                    <a href="<?php echo $server_name . "/about-us/#curators" ?>" target="_blank"><img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2023/01/starseke.png" ?>"></a>
                                                <?php
                                                } else if ($rating == "4") {
                                                ?>
                                                    <a href="<?php echo $server_name . "/about-us/#curators" ?>" target="_blank"><img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2023/01/starsyanti.png" ?>"></a>
                                                <?php
                                                } else if ($rating == "5") {
                                                ?>
                                                    <a href="<?php echo $server_name . "/about-us/#curators" ?>" target="_blank"><img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2023/01/starsdanielle.png" ?>"></a>

                                                <?php
                                                }
                                                ?>

                                            </div>
                                            <p style="color: #FF8250;" class="paratext shortdes"><?php echo do_shortcode($service[0]->short_excerpt); ?></p>
                                            <h2><?php echo do_shortcode('[woo_multi_currency_exchange price="' . $service[0]->price . '" currency="' . $curr . '"]'); ?></h2>


                                            <p>60 minutes including Q&A</p>

                                            <?php

                                            // getting cross sells
                                            $kdresults = $wpdb->get_results("SELECT `settings` FROM " . $wpdb->prefix . "amelia_services WHERE id= '" . $serviceid . "'");

                                            if ($wpdb->last_error) {
                                                echo 'wpdb error: ' . $wpdb->last_error;
                                            }

                                            $kdsettings = json_decode($kdresults[0]->settings);
                                            // print_r($kdsettings->payments->wc->productId);

                                            //$crosssellProductIds   =   get_post_meta($kdsettings->payments->wc->productId, '_crosssell_ids');
                                            //$crosssellProductIds    =   $crosssellProductIds[0];

                                            if (isset($kdsettings->payments->wc->productId)) {
                                                $crosssellProductIds = get_post_meta($kdsettings->payments->wc->productId, '_crosssell_ids');

                                                if (is_array($crosssellProductIds) && isset($crosssellProductIds[0])) {
                                                    $crosssellProductIds = $crosssellProductIds[0];
                                                } else {
                                                    // Handle the case where $crosssellProductIds is not an array or the first element is not set
                                                    $crosssellProductIds = null;
                                                }
                                            } else {
                                                // Handle the case where the 'productId' property is not set
                                                $crosssellProductIds = null;
                                            }



                                            // print_r($crosssellProductIds);

                                            ?>

                                             <!-- cross sells section -->
                                             <div class="kd-single-cross-sells-wrapper">
                                                            <!-- <h4 class="sessionttile"><b>You Might Also Like</b></h4> -->
                                                            <?php
                                                            global  $woocommerce;

                                                            if ($crosssellProductIds !== null) {
                                                            foreach ($crosssellProductIds as $crosssell) {
                                                                $cross_product = wc_get_product($crosssell);
                                                                $price = $cross_product->get_price();
                                                                $cross_url = get_the_permalink($crosssell);
                                                                $product_name = $cross_product->get_name();
                                                                $product_name_trimmed = preg_replace('/\(.*/', '', $product_name);

                                                                echo "<div class='kd-single-popup-cross-sell'><div class='name'>" . $product_name_trimmed . "</div><div class='price'>" . get_woocommerce_currency_symbol() . $price . "</div></div>";
                                                                // echo str_replace(' ', '-', $result->name) . '-' . $result->id;
                                                            }}
                                                            ?>
                                                        </div>

                                            <?php if (!empty($service[0]->videoViews) && intval($service[0]->videoViews) > 1000) { ?>
                                                <p class="viewscountsingle"> <?php echo number_format($service[0]->videoViews, 0, '.', ','); ?> views</p>
                                            <?php } ?>

                                            <div class="tagsdiv">
                                                <h6 class="field">Talks about :
                                                    <p><?php if ($service[0]->tag1 != null) { ?> <span><?php echo $service[0]->tag1 ?></span><?php } ?><?php if ($service[0]->tag2 != null) { ?> <span> | <?php echo $service[0]->tag2 ?></span><?php } ?><?php if ($service[0]->tag3 != null) { ?> <span> | <?php echo $service[0]->tag3 ?></span><?php } ?><?php if ($service[0]->tag4 != null) { ?> <span> | <?php echo $service[0]->tag4 ?></span><?php } ?><?php if ($service[0]->tag5 != null) { ?> <span> | <?php echo $service[0]->tag5 ?></span><?php } ?></p>
                                                </h6>
                                            </div>
                                            <!-- <br><br>
                                        <h6 class="field">Languages : <?php if ($service[0]->language1 != null) { ?> <span><?php echo $service[0]->language1 ?></span><?php } ?><?php if ($service[0]->language2 != null) { ?> <span> / <?php echo $service[0]->language2 ?></span><?php } ?><?php if ($service[0]->language3 != null) { ?> <span> / <?php echo $service[0]->language3 ?></span><?php } ?>
                                        </h6> -->

                                            <div class="sessiondiscription">

                                                <?php echo do_shortcode($service[0]->description); ?>
                                            </div>

                                            <div class="askquediv">

                                                <h4>Got a question?</h4>
                                                <?php
                                                echo do_shortcode('[quform id="4" name="single page form"]');

                                                ?>
                                            </div>
                                            </br></br>

                                        </div>









                                    </div>

                                </div>

                            </div>


                            <div class="col-md-6" id="calenderbooking">
                                <div class="session-buttons-rp">
                                    <a class="w3-bar-item w3-button bookingbtn booktypebtn">Book this session</a>

                                    <?php
                                    if ($preTalkId != "") {
                                    ?>
                                        <a class="w3-bar-item w3-button pretalkbtn booktypebtn">Meet the expert</a>

                                    <?php

                                    }
                                    ?>
                                </div>



                                <div id="bookingdiv" class="w3-container">

                                    <?php
                                    echo do_shortcode('[ameliastepbooking service="' . $serviceid . '"]');
                                    ?>
                                </div>

                                <div id="pretalkdiv" class="w3-container">
                                    <?php
                                    echo do_shortcode('[ameliastepbooking service="' . $preTalkId . '"]');
                                    ?>
                                </div>
                                <!-- 
                        <div class="w3-bar w3-black">
                            <button class="w3-bar-item w3-button" onclick="openCity('London')">Book this session</button>
                            <?php
                            //  if ($preTalkId != "") {

                            ?>
                                <button class="w3-bar-item w3-button" onclick="openCity('Paris')">Pre-Talk</button>
                            <?php
                            //   }
                            ?>
                        </div>

                        <div id="London" class="w3-container city">
                            <?php
                            //  echo do_shortcode('[ameliastepbooking service="' . $serviceid . '"]');
                            ?>
                        </div>

                        <div id="Paris" class="w3-container city" style="display:none">
                            <?php
                            //   echo do_shortcode('[ameliastepbooking service="' . $preTalkId . '"]');
                            ?>
                        </div> -->



                                <script>
                                    function openCity(cityName) {
                                        var i;
                                        var x = document.getElementsByClassName("city");
                                        for (i = 0; i < x.length; i++) {
                                            x[i].style.display = "none";
                                        }
                                        document.getElementById(cityName).style.display = "block";
                                    }
                                </script>

                            </div>
                        </div>

                    </div>
                    <div class="mainbody bookthissec">
                        <div class="subrow">
                            <div class="row">
                                <div class="ab-title" style="margin:0 auto;">Book this session</div>
                            </div>
                            <div class="row">
                                <div class="amiliyabooking">
                                    <?php
                                    //   echo do_shortcode('[ameliastepbooking service="' . $serviceid . '"]');

                                    ?>
                                </div>
                            </div>
                            </br>
                        </div>
                    </div>
                    <div class="mainbody abtexprt">
                        <div class="subrow">
                            <div class="row">
                                <div class="ab-title" style="margin:0 auto;">About the Speaker</div>
                            </div>
                            <div class="row author-box">


                                <div class="imgdiv desktop">
                                    <img class="abexpt" src=<?php echo $employee[0]->pictureFullPath ?>>
                                </div>
                                <div class="author-boxcol">
                                    <h3><?php echo $employee[0]->firstName . " " . $employee[0]->lastName; ?></h3>



                                    <h5> <?php echo $employee[0]->position; ?></h5>
                                    <div class="rate">
                                        <?php
                                        $empfullname2 = $employee[0]->full_name;
                                        $average1 = 0;
                                        $rate1 = 0;
                                        $reviewresult1 = $wpdb->get_results("SELECT * FROM `review_details` where user='$empfullname2'");
                                        foreach ($reviewresult1 as $row) {
                                            $count = count($reviewresult1);
                                            $review1 = $row->starreview;

                                            $rate1 += $review1;
                                            $average1 = $rate1 / $count;
                                        }
                                        $rating1 = round($average1);
                                        if ($rating1 == "1") {
                                        ?>
                                            <img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2022/09/star-3-1.png" ?>">
                                            <img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2022/10/emptystar.png" ?>">
                                            <img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2022/10/emptystar.png" ?>">
                                            <img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2022/10/emptystar.png" ?>">
                                            <img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2022/10/emptystar.png" ?>">


                                        <?php
                                        } else if ($rating1 == "2") {
                                        ?>
                                            <img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2022/09/star-3-1.png" ?>">
                                            <img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2022/09/star-3-1.png" ?>">
                                            <img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2022/10/emptystar.png" ?>">
                                            <img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2022/10/emptystar.png" ?>">
                                            <img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2022/10/emptystar.png" ?>">
                                        <?php
                                        } else if ($rating == "3") {
                                        ?>
                                            <a href="<?php echo $server_name . "/about-us/#curators" ?>" target="_blank"><img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2023/01/starseke.png" ?>"></a>
                                        <?php
                                        } else if ($rating == "4") {
                                        ?>
                                            <a href="<?php echo $server_name . "/about-us/#curators" ?>" target="_blank"><img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2023/01/starsyanti.png" ?>"></a>
                                        <?php
                                        } else if ($rating == "5") {
                                        ?>
                                            <a href="<?php echo $server_name . "/about-us/#curators" ?>" target="_blank"><img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2023/01/starsdanielle.png" ?>"></a>

                                        <?php
                                        }
                                        ?>


                                    </div>
                                    <div class="imgdiv mobile">
                                        <img class="abexpt" src=<?php echo $employee[0]->pictureFullPath ?>>
                                    </div>
                                    <div class="description">
                                        <?php echo do_shortcode(str_replace('\\', '', $employee[0]->bio)); ?>
                                    </div>

                                    <button type="button" class="btn btn-dark hidebtn">Get in contact</button>


                                </div>

                            </div>
                        </div>
                    </div>



                    <div class="row testisec ">
                        <div class="fulltestirow">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="carousel slide" data-ride="carousel" id="quote-carousel">
                                        <!-- Carousel Slides / Quotes -->
                                        <div class="carousel-inner text-center">
                                            <!-- Quote 1 -->
                                            <div class="item active">
                                                <blockquote>
                                                    <div class="row">
                                                        <div class="col-sm-11">
                                                            <p>We’ve had over 25 of these virtual expert sessions at L’Oréal UK. The team keeps surprising us with amazing content!</p>
                                                            <small>Amos Susskind</small>
                                                            <h6 class="authorname">Managing Director UK & Ireland<br>L'Oréal</h6>
                                                        </div>
                                                    </div>
                                                </blockquote>
                                            </div>
                                            <!-- Quote 2 -->
                                            <div class="item">
                                                <blockquote>
                                                    <div class="row">
                                                        <div class="col-sm-11">
                                                            <p>A great team that helps us develop and inspire our international management with a broad range of inspirational sessions</p>
                                                            <small>Jean-Paul Christy</small>
                                                            <h6 class="authorname">President Central Europe<br>Kärcher</h6>
                                                        </div>
                                                    </div>
                                                </blockquote>
                                            </div>
                                            <!-- Quote 3 -->
                                            <div class="item">
                                                <blockquote>
                                                    <div class="row">
                                                        <div class="col-sm-11">
                                                            <p>Great content and excellent service. Having done 150 sessions with them, I can easily recommend their speaker curation and their service.</p>
                                                            <small>Tré Sweeney</small>
                                                            <h6 class="authorname">Head of Learning and Development<br>Adyen</h6>
                                                        </div>
                                                    </div>
                                                </blockquote>
                                            </div>
                                            <!-- Quote 4 -->
                                            <div class="item">
                                                <blockquote>
                                                    <div class="row">
                                                        <div class="col-sm-11">
                                                            <p>We have been teaming up for over two years with Leqture, the team behind IWD Sessions, and their expert sessions have always been a big success</p>
                                                            <small>Lena Olivier</small>
                                                            <h6 class="authorname">Regional Vice President<br>Salesforce</h6>
                                                        </div>
                                                    </div>
                                                </blockquote>
                                            </div>
                                        </div>
                                        <!-- Bottom Carousel Indicators -->
                                        <ol class="carousel-indicators">
                                            <li data-target="#quote-carousel" data-slide-to="0" class="active"><img class="img-responsive " src="https://s3.amazonaws.com/uifaces/faces/twitter/mantia/128.jpg" alt="">
                                            </li>
                                            <li data-target="#quote-carousel" data-slide-to="1"><img class="img-responsive" src="https://s3.amazonaws.com/uifaces/faces/twitter/adhamdannaway/128.jpg" alt="">
                                            </li>
                                            <li data-target="#quote-carousel" data-slide-to="2"><img class="img-responsive" src="https://s3.amazonaws.com/uifaces/faces/twitter/brad_frost/128.jpg" alt="">
                                            </li>
                                            <li data-target="#quote-carousel" data-slide-to="3"><img class="img-responsive" src="https://s3.amazonaws.com/uifaces/faces/twitter/brad_frost/128.jpg" alt="">
                                            </li>
                                        </ol>

                                        <!-- Carousel Buttons Next/Prev -->
                                        <!--<a data-slide="prev" href="#quote-carousel" class="left carousel-control"><i class="fa fa-chevron-left"></i></a>  -->
                                        <!--<a data-slide="next" href="#quote-carousel" class="right carousel-control"><i class="fa fa-chevron-right"></i></a> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="mainbody reviewsecl" style="display:none;">
                        <div class="subrow">
                            <div class="review row">
                                <div class="ab-title" style="margin:0 auto;">Reviews</div>
                                <div class="ab-sub_title" style="margin:0 auto;">Lorem ipsum dolor sit amet, quando inimicus patrioque quo ex, est ut putent ceteros vulputate, phaedrum liberavisse ut vis. Mei delenit forensibus reformidans eu, te sumo ipsum dissentiet quo. Per ei enim nullam audiam, sea laboramus.</div>
                            </div>
                            <div class="row newrow">
                                <div class="col-lg-3 col-sm-12">
                                    <div class="revew">
                                        <div class="absec-title">Stewart Gilbert</div>
                                        <div class="revew-description">
                                            <p></p>
                                        </div>
                                        <div class="date">
                                            23 Aug 2022
                                        </div>
                                        <div class="rate testirate">

                                            <img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2022/08/star-3.png" ?>">
                                            <img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2022/08/star-3.png" ?>">
                                            <img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2022/08/star-3.png" ?>">
                                            <img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2022/08/star-3.png" ?>">
                                            <img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2022/08/star-3.png" ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <div class="revew">
                                        <div class="absec-title">Clement Burgess</div>
                                        <div class="revew-description">
                                            <p></p>
                                        </div>
                                        <div class="date">
                                            23 Aug 2022
                                        </div>
                                        <div class="rate testirate">
                                            <img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2022/08/star-3.png" ?>">
                                            <img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2022/08/star-3.png" ?>">
                                            <img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2022/08/star-3.png" ?>">
                                            <img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2022/08/star-3.png" ?>">
                                            <img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2022/08/star-3.png" ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <div class="revew">
                                        <div class="absec-title">Emma Hill</div>
                                        <div class="revew-description">
                                            <p></p>
                                        </div>
                                        <div class="date">
                                            23 Aug 2022
                                        </div>
                                        <div class="rate testirate">
                                            <img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2022/08/star-3.png" ?>">
                                            <img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2022/08/star-3.png" ?>">
                                            <img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2022/08/star-3.png" ?>">
                                            <img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2022/08/star-3.png" ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-12">
                                    <div class="revew">
                                        <div class="absec-title">Tony DDD</div>
                                        <div class="revew-description">
                                            <p></p>
                                        </div>
                                        <div class="date">

                                            23 Aug 2022
                                        </div>
                                        <div class="rate testirate">
                                            <img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2022/08/star-3.png" ?>">
                                            <img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2022/08/star-3.png" ?>">
                                            <img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2022/08/star-3.png" ?>">
                                            <img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2022/08/star-3.png" ?>">
                                            <img class="star-rating" src="<?php echo $server_name . "/wp-content/uploads/2022/08/star-3.png" ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>






                    <!--Unload Preloader-->
                    <script>
                        window.addEventListener("load", function() {
                            var preloader = document.getElementById('preloader');
                            preloader.style.display = 'none';
                            document.body.classList.remove("preloader-active");
                        });
                    </script>
                    <noscript>
                        <style>
                            #preloader {
                                display: none;
                            }
                        </style>
                        <p>Your browser has JavaScript disabled. Some features on this website may not work properly. Please enable JavaScript for the best experience.</p>
                    </noscript>


                </div>
        </div><!-- containerend -->
    <?php
    }
    ?>
</main>

<script>
    $(document).ready(function() {
        $("#pretalkdiv").css("visibility", "hidden");
        $("#pretalkdiv").css("height", "0");
        $('.bookingbtn').addClass("activebtn");
        $(".pretalkbtn").click(function() {
            $(this).addClass("activebtn");
            $(".bookingbtn").removeClass("activebtn");
            $("#bookingdiv").css("visibility", "hidden");
            $("#bookingdiv").css("height", "0");
            $("#pretalkdiv").css("visibility", "visible");
            $("#pretalkdiv").css("height", "auto");

            // $("#pretalkdiv").show();
            // $("#bookingdiv").hide();
        });
        $(".bookingbtn").click(function() {
            $(".pretalkbtn").removeClass("activebtn");
            $(this).addClass("activebtn");
            $("#pretalkdiv").css("visibility", "hidden");
            $("#pretalkdiv").css("height", "0");
            $("#bookingdiv").css("visibility", "visible");
            $("#bookingdiv").css("height", "auto");
        });

        function openCity(cityName) {
            var i;
            var x = document.getElementsByClassName("bookType");
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            document.getElementById(cityName).style.display = "block";
        }

        var owl = $('.logosec .owl-carousel');
        owl.owlCarousel({

            loop: true,
            margin: 10,
            autoplay: true,
            autoplayTimeout: 1000,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 1
                },

                600: {
                    items: 3
                },

                1024: {
                    items: 4
                },

                1366: {
                    items: 4
                }
            }
        });

    });

    $(document).ready(function() {
        var owl = $('.MoreSessions .owl-carousel');
        owl.owlCarousel({
            margin: 10,
            loop: false,
            nav: true,
            mouseDrag: true,
            responsiveClass: true,
            responsiveRefreshRate: 200,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 3
                },
                1024: {
                    items: 4
                },
                1366: {
                    items: 6
                },
                2080: {
                    items: 7
                }
            }
        });

    });
</script>
<?php get_sidebar('content-bottom'); ?>
</div><!-- .content-area -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>