<style>
    /* Footer Styles */
    .myfooter {
        background-color: #2c3e50;
        color: #ecf0f1;
        padding: 3rem 0 1.5rem;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        position: relative;
        overflow: hidden;
    }

    .myfooter::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #27ae60, #f1c40f);
    }

    .myfooter h4 {
        color: #f1c40f;
        font-weight: 600;
        margin-bottom: 1.5rem;
        position: relative;
        display: inline-block;
    }

    .myfooter h4::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 50%;
        transform: translateX(-50%);
        width: 50px;
        height: 2px;
        background-color: #27ae60;
    }

    .footerimg {
        width: 100px;
        height: 40px;
        margin: 0 10px;
        transition: all 0.3s ease;
        filter: grayscale(30%);
    }

    .footerimg:hover {
        transform: translateY(-3px);
        filter: grayscale(0%);
    }

    .social {
        padding: 0;
        margin: 1.5rem 0;
    }

    .social .list-inline-item {
        margin: 0 8px;
    }

    .social .list-inline-item a {
        color: #bdc3c7;
        background: #34495e;
        width: 40px;
        height: 40px;
        line-height: 40px;
        display: inline-block;
        text-align: center;
        border-radius: 50%;
        transition: all 0.3s ease;
        font-size: 18px;
    }

    .social .list-inline-item a:hover {
        color: white;
        background: #27ae60;
        transform: translateY(-5px) rotate(5deg);
    }

    .myfooter p {
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .myfooter a {
        color: #f1c40f;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .myfooter a:hover {
        color: #27ae60;
        text-decoration: underline;
    }

    .text-green {
        color: #27ae60 !important;
    }

    /* Animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .footer-animate {
        animation: fadeInUp 0.8s ease forwards;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .footerimg {
            width: 80px;
            height: 32px;
            margin: 0 5px;
        }
        
        .social .list-inline-item {
            margin: 0 5px;
        }
        
        .social .list-inline-item a {
            width: 36px;
            height: 36px;
            line-height: 36px;
            font-size: 16px;
        }
    }
</style>

<!-- Load Font Awesome CSS in head -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="container myfooter">
    <div class="row text-center text-xs-center text-sm-left text-md-left footer-animate">
        <div class="col aligncenter">
            <h4>Payment Option</h4>
            <img class="footerimg" src="../Images/Website/paytm1.jpg" alt="paytm">
            <img class="footerimg" src="../Images/Website/cod.jpg" alt="cash on delivery" style="height:40px">
        </div>
        
    </div>
    <div class="row footer-animate" style="animation-delay: 0.2s;">
        <div class="col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-5">
            <ul class="list-unstyled list-inline social text-center">
                <li class="list-inline-item"><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                <li class="list-inline-item"><a href="#"><i class="fab fa-twitter"></i></a></li>
                <li class="list-inline-item"><a href="../Administartion/Adminlogin.php"><i class="fas fa-user-shield admin-icon"></i></a></li>
                <li class="list-inline-item"><a href="#"><i class="fab fa-instagram"></i></a></li>
                <li class="list-inline-item"><a href="#"><i class="fab fa-google-plus-g"></i></a></li>
                <li class="list-inline-item"><a href="#"><i class="fas fa-envelope"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="row footer-animate" style="animation-delay: 0.4s;">
        <div class="col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-2 text-center">
            <p><u><a href="https://www.agrocraft.com/">AgroCraft Corporation</a></u> is a Multitrading Company for farmers and traders</p>
            <p class="h6">Copy All right Reversed.<a class="text-green ml-2" href="https://www.google.com" target="_blank">Agrotech</a></p>
        </div>
    </div>
</div>

<script>
    // Add animation class when footer comes into view
    document.addEventListener('DOMContentLoaded', function() {
        const footer = document.querySelector('.myfooter');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const animatedElements = entry.target.querySelectorAll('.footer-animate');
                    animatedElements.forEach((el, index) => {
                        setTimeout(() => {
                            el.style.opacity = 1;
                        }, index * 200);
                    });
                }
            });
        }, { threshold: 0.1 });
        
        observer.observe(footer);
    });
</script>