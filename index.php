<?php

if(!empty($_FILES['image'])){

    #then execute this code when there is image uploaded
    echo "yeeeeeeeeees";
}else{
    #execute this
}

if (isset($_POST['submit'])) {
 
    //allowed file types
    $arr_file_types = ['image/png', 'image/gif', 'image/jpg', 'image/jpeg'];
 
    if (!(in_array($_FILES['image']['type'], $arr_file_types))) {
 
        die('Only image is allowed!');
    }
 
    if (!file_exists('uploads')) {
        mkdir('uploads', 0777);
        // echo "test";
    }
 
    move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $_FILES['image']['name']);
 
    // optimize image using reSmush.it
    $file = getcwd(). '/uploads/' . $_FILES['image']['name'];
    $mime = mime_content_type($file);
    $info = pathinfo($file);
    $name = $info['basename'];
    $output = new CURLFile($file, $mime, $name);
    $data = array(
        "files" => $output,
    );
 
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://api.resmush.it/?qlty=80');
    curl_setopt($ch, CURLOPT_POST,1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $result = curl_exec($ch);
    if (curl_errno($ch)) {
       $result = curl_error($ch);
    }
    curl_close ($ch);
 
    $arr_result = json_decode($result);
 
    // store the optimized version of the image
    $ch = curl_init($arr_result->dest);
    $fp = fopen(getcwd(). '/uploads/'. $name, 'wb');
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_exec($ch);
    curl_close($ch);
    fclose($fp);
    
      echo $name;
 
    echo "File uploaded successfully.";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/fontawesome.min.css"
        crossorigin="anonymous"></script>
    <link type="text/css" href="https://cdn.jotfor.ms/before-after/before-after.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">


</head>

<body>
    <nav class="navbar">
        <div class="container">

            <a href="" class="navbar-brand">
                <img src="" alt="">
                <h3 class="d-inline align-middle">Compresse Me</h3>

            </a>

            <ul class="nav justify-content-end">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Active</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
            </ul>
        </div>


    </nav>


    <section class="showcase py-5">

        <div data-tilt data-tilt-axis="x" class="showcase__img ba-slider">
            <img src="img/showcase.jpg" alt="" width="1000px" height="700px">
            <div class="resize">
                <img src="img/showcase.jpg" alt="" width="1000px" height="700px">
            </div>
            <span class="handle"></span>
        </div>

        <svg class="navbar_svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 144.54 17.34" preserveAspectRatio="none"
            fill="currentColor">
            <path d="M144.54,17.34H0V0H144.54ZM0,0S32.36,17.34,72.27,17.34,144.54,0,144.54,0"></path>
        </svg>
    </section>


    <section class="section_compress py-5">
        <div class="container">
            <div class="about-section">
                <h3 class="about-section__heading">Fast And Easy Way To Compresse Your Image</h3>
                <span class="about-section__type">JPG,PNG,JPEG,WEBP,SVG</span>
            </div>

            <form method="POST" class="section_compress__form" enctype="multipart/form-data">
                <div class="form-group">
                    <h3 class="form-group__heading">Drop Your Image Here</h3>
                    <p>OR</p>
                    <label for="exampleFormControlFile1" class="form-group__btn">Add file</label>
                    <input type="file" name="image" class="form-control-file" id="exampleFormControlFile1" multiple="" accept="image/*">
                    <input type="submit" name="submit" value="Submit">
                </div>
            </form>
        </div>

    </section>



    <footer class="footer">
        <svg class="footer_svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 144.54 17.34" preserveAspectRatio="none"
            fill="currentColor">
            <path d="M144.54,17.34H0V0H144.54ZM0,0S32.36,17.34,72.27,17.34,144.54,0,144.54,0"></path>
        </svg>
        <div class="container">
            <div class="footer__socialmedia">
                <h5>compresse me</h5>
                <ul>
                    <li><a href=""><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href=""><i class="fab fa-instagram"></i></a></li>
                    <li><a href=""><i class="fab fa-github"></i></a></li>
                </ul>
            </div>
            <hr class="footer__devider">
            <div class="copyright">
                <h6 class="copyright__text">copyright &copy compressme.com</h6>
                <ul class="copyright__liens">
                    <li><a href="">term of use</a></li>
                    <li><a href="">privacy policy</a></li>
                </ul>
            </div>


        </div>
    </footer>






    <script type="text/javascript" src="js/tilt.js"></script>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"
        integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.jotfor.ms/before-after/before-after.min.js"></script>
    <script type="text/javascript">
        // Call & init
        $(document).ready(function () {
            $('.ba-slider').each(function () {
                var cur = $(this);
                // Adjust the slider
                var width = cur.width() + 'px';
                cur.find('.resize img').css('width', width);
                // Bind dragging events
                drags(cur.find('.handle'), cur.find('.resize'), cur);
            });
        });

        // Update sliders on resize. 
        // Because we all do this: i.imgur.com/YkbaV.gif
        $(window).resize(function () {
            $('.ba-slider').each(function () {
                var cur = $(this);
                var width = cur.width() + 'px';
                cur.find('.resize img').css('width', width);
            });
        });

        function drags(dragElement, resizeElement, container) {

            // Initialize the dragging event on mousedown.
            dragElement.on('mousedown touchstart', function (e) {

                dragElement.addClass('draggable');
                resizeElement.addClass('resizable');

                // Check if it's a mouse or touch event and pass along the correct value
                var startX = (e.pageX) ? e.pageX : e.originalEvent.touches[0].pageX;

                // Get the initial position
                var dragWidth = dragElement.outerWidth(),
                    posX = dragElement.offset().left + dragWidth - startX,
                    containerOffset = container.offset().left,
                    containerWidth = container.outerWidth();

                // Set limits
                minLeft = containerOffset + 10;
                maxLeft = containerOffset + containerWidth - dragWidth - 10;

                // Calculate the dragging distance on mousemove.
                dragElement.parents().on("mousemove touchmove", function (e) {

                    // Check if it's a mouse or touch event and pass along the correct value
                    var moveX = (e.pageX) ? e.pageX : e.originalEvent.touches[0].pageX;

                    leftValue = moveX + posX - dragWidth;

                    // Prevent going off limits
                    if (leftValue < minLeft) {
                        leftValue = minLeft;
                    } else if (leftValue > maxLeft) {
                        leftValue = maxLeft;
                    }

                    // Translate the handle's left value to masked divs width.
                    widthValue = (leftValue + dragWidth / 2 - containerOffset) * 100 / containerWidth + '%';

                    // Set the new values for the slider and the handle. 
                    // Bind mouseup events to stop dragging.
                    $('.draggable').css('left', widthValue).on('mouseup touchend touchcancel', function () {
                        $(this).removeClass('draggable');
                        resizeElement.removeClass('resizable');
                    });
                    $('.resizable').css('width', widthValue);
                }).on('mouseup touchend touchcancel', function () {
                    dragElement.removeClass('draggable');
                    resizeElement.removeClass('resizable');
                });
                e.preventDefault();
            }).on('mouseup touchend touchcancel', function (e) {
                dragElement.removeClass('draggable');
                resizeElement.removeClass('resizable');
            });
        }
        $('.ba-slider').beforeAfter();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
        crossorigin="anonymous"></script>
</body>

</html>