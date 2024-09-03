<!DOCTYPE html>
<html lang="en">

@include('head')

<body class="index-page">

  @include('header')


  <main class="main">

    <!-- Sección Banner -->
    <section id="hero" class="hero section dark-background">

      <img src="assets/img/banner.jpg" alt="" data-aos="fade-in">

      <div class="container">

        <div class="row justify-content-center text-center" data-aos="fade-up" data-aos-delay="100">
          <div class="col-xl-6 col-lg-8">
            <h2>Bienvenido a tu sitio,</h2>
            <h2>FitZone Club<span>.</span></h2>
            <p>Tu espacio para fortalecer cuerpo y mente</p>
          </div>
        </div>

        <div class="row gy-4 mt-5 justify-content-center" data-aos="fade-up" data-aos-delay="200">
          <div class="col-xl-2 col-md-4" data-aos="fade-up" data-aos-delay="300">
            <div class="icon-box">
              <i class="fa-solid fa-dumbbell"></i>
              <h3><a href="">Zonas de Musculación</a></h3>
            </div>
          </div>
          <div class="col-xl-2 col-md-4" data-aos="fade-up" data-aos-delay="400">
            <div class="icon-box">
              <i class="fa-solid fa-heart-pulse"></i>
              <h3><a href="">Clases de Cardio</a></h3>
            </div>
          </div>
          <div class="col-xl-2 col-md-4" data-aos="fade-up" data-aos-delay="500">
            <div class="icon-box">
              <i class="fa-solid fa-gear"></i>
              <h3><a href="">Máquinas next level</a></h3>
            </div>
          </div>
          <div class="col-xl-2 col-md-4" data-aos="fade-up" data-aos-delay="600">
            <div class="icon-box">
              <i class="fa-solid fa-hands"></i>
              <h3><a href="">Servicio de Rehabilitación</a></h3>
            </div>
          </div>
          <div class="col-xl-2 col-md-4" data-aos="fade-up" data-aos-delay="700">
            <div class="icon-box">
              <i class="fa-solid fa-apple-whole"></i>
              <h3><a href="">La mejor Dietética</a></h3>
            </div>
          </div>
        </div>

      </div>

    </section>
    </section>
    <!-- /Seccion Banner -->

    <!-- Sección Nosotros -->
    <section id="about" class="about section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">
          <div class="col-lg-6 order-1 order-lg-2">
            <img src="assets/img/about.jpg" class="img-fluid" alt="">
          </div>
          <div class="col-lg-6 order-2 order-lg-1 content">
            <h3>FitZone Club es tu nuevo hogar</h3>
            <p class="fst-italic">
              En FitZone Club, estamos dedicados a proporcionar un ambiente de entrenamiento de primer nivel donde cada
              miembro puede alcanzar sus objetivos de salud y fitness.
              Nuestro gimnasio está equipado con instalaciones modernas y ofrecemos una amplia gama de servicios
              diseñados para satisfacer las necesidades de todos, desde principiantes hasta atletas avanzados.
            </p>
            <ul>
              <li><i class="bi bi-check2-all"></i> <span>Áreas especializadas en musculación con equipamiento de última
                  generación.</span></li>
              <li><i class="bi bi-check2-all"></i> <span>Zonas de cardio con tecnología avanzada para un entrenamiento
                  efectivo.</span></li>
              <li><i class="bi bi-check2-all"></i> <span>Programas de rehabilitación personalizados para apoyar tu
                  recuperación y bienestar.</span></li>
            </ul>
            <p>
              Además, en FitZone Club ofrecemos asesoramiento dietético y planes nutricionales diseñados por expertos
              para complementar tu entrenamiento y ayudarte a alcanzar tus metas de forma saludable.
              Únete a nuestra comunidad y descubre cómo podemos ayudarte a transformar tu vida.
            </p>
          </div>
        </div>

      </div>

    </section><!-- /About Section -->

    <!-- Sección empresas  -->
    <section id="clients" class="clients section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="swiper init-swiper">
          <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "speed": 600,
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": "auto",
              "pagination": {
                "el": ".swiper-pagination",
                "type": "bullets",
                "clickable": true
              },
              "breakpoints": {
                "320": {
                  "slidesPerView": 2,
                  "spaceBetween": 40
                },
                "480": {
                  "slidesPerView": 3,
                  "spaceBetween": 60
                },
                "640": {
                  "slidesPerView": 4,
                  "spaceBetween": 80
                },
                "992": {
                  "slidesPerView": 6,
                  "spaceBetween": 120
                }
              }
            }
          </script>
          <div class="swiper-wrapper align-items-center">
            <div class="swiper-slide"><img src="assets/img/clients/client-1.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-2.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-3.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-4.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-5.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-6.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-7.png" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/client-8.png" class="img-fluid" alt=""></div>
          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>

    </section><!-- /Clients Section -->

    <!-- Sección servicios -->
    <section id="services" class="services section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Servicios</h2>
        <p>Sobre nuestros servicios</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="service-item position-relative">
              <div class="icon">
                <i class="fa-solid fa-dumbbell"></i>
              </div>
              <a href="service-details.html" class="stretched-link">
                <h3>Musculación</h3>
              </a>
              <p>Transforma tu cuerpo en nuestras zonas de musculación, equipadas con pesas libres y máquinas de última
                generación para todos los niveles de entrenamiento.</p>
            </div>
          </div><!-- End Service Item -->

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="service-item position-relative">
              <div class="icon">
                <i class="fa-solid fa-heart-pulse"></i>
              </div>
              <a href="service-details.html" class="stretched-link">
                <h3>Clases de Cardio</h3>
              </a>
              <p>Mantén tu corazón en forma con nuestras dinámicas clases de cardio, diseñadas para quemar calorías y
                mejorar tu resistencia cardiovascular.</p>
            </div>
          </div><!-- End Service Item -->

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
            <div class="service-item position-relative">
              <div class="icon">
                <i class="fa-solid fa-gear"></i>
              </div>
              <a href="service-details.html" class="stretched-link">
                <h3>Máquinas next level</h3>
              </a>
              <p>Experimenta la última tecnología en entrenamiento con nuestras máquinas de alta gama, que se adaptan a
                tus necesidades y te ayudan a maximizar cada sesión.</p>
            </div>
          </div><!-- End Service Item -->

        </div><!-- End First Row -->

        <div class="row gy-4 justify-content-center">

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
            <div class="service-item position-relative">
              <div class="icon">
                <i class="fa-solid fa-hands"></i>
              </div>
              <a href="service-details.html" class="stretched-link">
                <h3>Servicio de rehabilitación</h3>
              </a>
              <p>Recupera tu movilidad y bienestar con nuestro servicio de rehabilitación, dirigido por expertos en
                fisioterapia que te acompañarán en cada paso de tu recuperación.</p>
              <a href="service-details.html" class="stretched-link"></a>
            </div>
          </div><!-- End Service Item -->

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
            <div class="service-item position-relative">
              <div class="icon">
                <i class="fa-solid fa-apple-whole"></i>
              </div>
              <a href="service-details.html" class="stretched-link">
                <h3>La mejor dietética</h3>
              </a>
              <p>Complementa tu entrenamiento con nuestros planes dietéticos personalizados, diseñados para optimizar tu
                rendimiento y ayudarte a alcanzar tus objetivos de salud y fitness.</p>
              <a href="service-details.html" class="stretched-link"></a>
            </div>
          </div><!-- End Service Item -->

        </div><!-- End Second Row -->

      </div>

    </section><!-- /Services Section -->

    <!-- Sección Unirte -->
    <section id="call-to-action" class="call-to-action section dark-background">

      <img src="assets/img/cta-bg.jpg" alt="">

      <div class="container">
        <div class="row justify-content-center" data-aos="zoom-in" data-aos-delay="100">
          <div class="col-xl-10">
            <div class="text-center">
              <h3>Únete a FitZone Club</h3>
              <p>Descubre una nueva forma de entrenar en FitZone Club. Ya sea que busques mejorar tu salud, ganar masa
                muscular, o simplemente disfrutar de un estilo de vida más activo, nuestro equipo de profesionales está
                aquí para ayudarte a alcanzar tus metas. ¡No esperes más para transformar tu vida!</p>
              <a class="cta-btn" href="#">¡Hazte miembro!</a>
            </div>
          </div>
        </div>
      </div>

    </section><!-- /Sección Unirte -->

    <!-- Sección opiniones -->
    <section id="testimonials" class="testimonials section dark-background">
      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="swiper init-swiper">
          <script type="application/json" class="swiper-config">
        {
          "loop": true,
          "speed": 600,
          "autoplay": {
            "delay": 5000
          },
          "slidesPerView": "auto",
          "pagination": {
            "el": ".swiper-pagination",
            "type": "bullets",
            "clickable": true
          }
        }
      </script>
          <div class="swiper-wrapper">

            <div class="swiper-slide">
              <div class="testimonial-item">
                <img src="assets/img/testimonials/testimonials-1.jpg" class="testimonial-img" alt="">
                <h3>Carlos Martínez</h3>
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                    class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>FitZone Club ha cambiado mi vida. Las instalaciones son de primera, y el equipo siempre está
                    dispuesto a ayudar. ¡Lo recomiendo al 100%!</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <img src="assets/img/testimonials/testimonials-2.jpg" class="testimonial-img" alt="">
                <h3>María López</h3>
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                    class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>Las clases de cardio son increíbles. Cada sesión es un desafío, pero con el apoyo de los
                    entrenadores, siempre me siento motivada a dar lo mejor de mí.</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <img src="assets/img/testimonials/testimonials-3.jpg" class="testimonial-img" alt="">
                <h3>Javier Gómez</h3>
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                    class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>La zona de musculación de FitZone Club es impresionante. Tienen todo el equipo necesario para
                    entrenar al máximo nivel. ¡Es mi lugar favorito para entrenar!</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <img src="assets/img/testimonials/testimonials-4.jpg" class="testimonial-img" alt="">
                <h3>Laura Fernández</h3>
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                    class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>Después de mi lesión, FitZone Club me ayudó en mi recuperación con su excelente servicio de
                    rehabilitación. ¡No podría estar más agradecida!</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <img src="assets/img/testimonials/testimonials-5.jpg" class="testimonial-img" alt="">
                <h3>Sergio Álvarez</h3>
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                    class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>FitZone Club ofrece un servicio integral, desde las máquinas de última tecnología hasta
                    asesoramiento en dietética. ¡Todo lo que necesito para mantenerme en forma!</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
              </div>
            </div><!-- End testimonial item -->

          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>

    </section><!-- /Testimonials Section -->

<!-- Sección equipo -->
<section id="team" class="team section">

  <!-- Título de la Sección -->
  <div class="container section-title" data-aos="fade-up">
    <h2>Equipo</h2>
    <p>Nuestro Equipo</p>
  </div><!-- Fin del Título de la Sección -->

  <div class="container">

    <div class="row gy-4">

      <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
        <div class="team-member">
          <div class="member-img">
            <img src="assets/img/team/team-1.jpg" class="img-fluid" alt="">
            <div class="social">
              <a href=""><i class="bi bi-twitter-x"></i></a>
              <a href=""><i class="bi bi-facebook"></i></a>
              <a href=""><i class="bi bi-instagram"></i></a>
              <a href=""><i class="bi bi-linkedin"></i></a>
            </div>
          </div>
          <div class="member-info">
            <h4>Carlos Sánchez</h4>
            <span>Entrenador Personal y Musculación</span>
          </div>
        </div>
      </div><!-- Fin del Miembro del Equipo -->

      <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
        <div class="team-member">
          <div class="member-img">
            <img src="assets/img/team/team-2.jpg" class="img-fluid" alt="">
            <div class="social">
              <a href=""><i class="bi bi-twitter-x"></i></a>
              <a href=""><i class="bi bi-facebook"></i></a>
              <a href=""><i class="bi bi-instagram"></i></a>
              <a href=""><i class="bi bi-linkedin"></i></a>
            </div>
          </div>
          <div class="member-info">
            <h4>María López</h4>
            <span>Especialista en Rehabilitación</span>
          </div>
        </div>
      </div><!-- Fin del Miembro del Equipo -->

      <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="300">
        <div class="team-member">
          <div class="member-img">
            <img src="assets/img/team/team-3.jpg" class="img-fluid" alt="">
            <div class="social">
              <a href=""><i class="bi bi-twitter-x"></i></a>
              <a href=""><i class="bi bi-facebook"></i></a>
              <a href=""><i class="bi bi-instagram"></i></a>
              <a href=""><i class="bi bi-linkedin"></i></a>
            </div>
          </div>
          <div class="member-info">
            <h4>Javier Gómez</h4>
            <span>Instructor de Cardio</span>
          </div>
        </div>
      </div><!-- Fin del Miembro del Equipo -->

      <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="400">
        <div class="team-member">
          <div class="member-img">
            <img src="assets/img/team/team-4.jpg" class="img-fluid" alt="">
            <div class="social">
              <a href=""><i class="bi bi-twitter-x"></i></a>
              <a href=""><i class="bi bi-facebook"></i></a>
              <a href=""><i class="bi bi-instagram"></i></a>
              <a href=""><i class="bi bi-linkedin"></i></a>
            </div>
          </div>
          <div class="member-info">
            <h4>Laura Fernández</h4>
            <span>Nutricionista y Dietética</span>
          </div>
        </div>
      </div><!-- Fin del Miembro del Equipo -->

    </div>

  </div>

</section><!-- /Sección del Equipo -->


<!-- Sección de contacto -->
<section id="contact" class="contact section">

  <!-- Título de la sección -->
  <div class="container section-title" data-aos="fade-up">
    <h2>Contacto</h2>
    <p>Contáctanos</p>
  </div><!-- Fin del título de la sección -->

  <div class="container" data-aos="fade-up" data-aos-delay="100">

    <div class="mb-4" data-aos="fade-up" data-aos-delay="200">
      <iframe style="border:0; width: 100%; height: 270px;"
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d26487.538498588914!2d-5.994319899999999!3d37.3978218!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd126dc674ed2cf9%3A0x41b09aceddcfb7e5!2sCentro%20Comercial%20Los%20Arcos!5e0!3m2!1ses!2ses!4v1724945898558!5m2!1ses!2ses"
        frameborder="0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div><!-- Fin de Google Maps -->

    <div class="row gy-4">

      <div class="col-lg-4">
        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
          <i class="bi bi-geo-alt flex-shrink-0"></i>
          <div>
            <h3>Dirección</h3>
            <p>Centro Comercial Los Arcos, Sevilla, España</p>
          </div>
        </div><!-- Fin del elemento de información -->

        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
          <i class="bi bi-telephone flex-shrink-0"></i>
          <div>
            <h3>Llámanos</h3>
            <p>+34 1234 567 890</p>
          </div>
        </div><!-- Fin del elemento de información -->

        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="500">
          <i class="bi bi-envelope flex-shrink-0"></i>
          <div>
            <h3>Envíanos un correo</h3>
            <p>info@fitzoneclub.com</p>
          </div>
        </div><!-- Fin del elemento de información -->

      </div>

      <div class="col-lg-8">
        <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade-up"
          data-aos-delay="200">
          <div class="row gy-4">

            <div class="col-md-6">
              <input type="text" name="name" class="form-control" placeholder="Tu Nombre" required="">
            </div>

            <div class="col-md-6">
              <input type="email" class="form-control" name="email" placeholder="Tu Correo Electrónico" required="">
            </div>

            <div class="col-md-12">
              <input type="text" class="form-control" name="subject" placeholder="Asunto" required="">
            </div>

            <div class="col-md-12">
              <textarea class="form-control" name="message" rows="6" placeholder="Mensaje" required=""></textarea>
            </div>

            <div class="col-md-12 text-center">
              <div class="loading">Cargando</div>
              <div class="error-message"></div>
              <div class="sent-message">Tu mensaje ha sido enviado. ¡Gracias!</div>

              <button type="submit">Enviar Mensaje</button>
            </div>

          </div>
        </form>
      </div><!-- Fin del formulario de contacto -->

    </div>

  </div>

</section><!-- /Sección de contacto -->


  </main>

  <footer id="footer" class="footer dark-background">

<div class="footer-top">
  <div class="container">
    <div class="row gy-4">
      <div class="col-lg-4 col-md-6 footer-about">
        <a href="index.html" class="logo d-flex align-items-center">
          <span class="sitename">FitZone Club</span>
        </a>
        <div class="footer-contact pt-3">
          <p>Centro Comercial Los Arcos, Sevilla, España</p>
          <p class="mt-3"><strong>Teléfono:</strong> <span>+34 1234 567 890</span></p>
          <p><strong>Email:</strong> <span>info@fitzoneclub.com</span></p>
        </div>
        <div class="social-links d-flex mt-4">
          <a href="#"><i class="bi bi-twitter"></i></a>
          <a href="#"><i class="bi bi-facebook"></i></a>
          <a href="#"><i class="bi bi-instagram"></i></a>
          <a href="#"><i class="bi bi-linkedin"></i></a>
        </div>
      </div>

      <div class="col-lg-2 col-md-3 footer-links">
        <h4>Enlaces Útiles</h4>
        <ul>
          <li><i class="bi bi-chevron-right"></i> <a href="#">Inicio</a></li>
          <li><i class="bi bi-chevron-right"></i> <a href="#about">Sobre Nosotros</a></li>
          <li><i class="bi bi-chevron-right"></i> <a href="#services">Servicios</a></li>
          <li><i class="bi bi-chevron-right"></i> <a href="#">Términos del Servicio</a></li>
          <li><i class="bi bi-chevron-right"></i> <a href="#">Política de Privacidad</a></li>
        </ul>
      </div>

      <div class="col-lg-2 col-md-3 footer-links">
        <h4>Nuestros Servicios</h4>
        <ul>
          <li><i class="bi bi-chevron-right"></i> <a href="#">Musculación</a></li>
          <li><i class="bi bi-chevron-right"></i> <a href="#">Cardio</a></li>
          <li><i class="bi bi-chevron-right"></i> <a href="#">Rehabilitación</a></li>
          <li><i class="bi bi-chevron-right"></i> <a href="#">Dietética</a></li>
          <li><i class="bi bi-chevron-right"></i> <a href="#">Entrenamiento Personal</a></li>
        </ul>
      </div>

      <div class="col-lg-4 col-md-12 footer-newsletter">
        <h4>Suscríbete a nuestro Boletín</h4>
        <p>Recibe las últimas noticias sobre nuestros servicios y promociones especiales.</p>
        <form action="forms/newsletter.php" method="post" class="php-email-form">
          <div class="newsletter-form"><input type="email" name="email"><input type="submit" value="Suscribirse">
          </div>
          <div class="loading">Cargando</div>
          <div class="error-message"></div>
          <div class="sent-message">Tu solicitud de suscripción ha sido enviada. ¡Gracias!</div>
        </form>
      </div>

    </div>
  </div>
</div>

<div class="copyright">
  <div class="container text-center">
    <p>© <span>Copyright</span> <strong class="px-1 sitename">FitZone Club</strong> <span>Todos los derechos reservados</span></p>
    </div>
  </div>
</div>

</footer>


  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>