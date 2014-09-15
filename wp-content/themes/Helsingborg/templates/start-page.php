<?php
/*
Template Name: Startsida
*/
get_header(); ?>

<div class="main-page-layout row">
    <!-- main-page-layout -->
    <div class="main-area large-9 columns">

        <div class="row">
            <div class="large-12 columns slider-container">
              <div class="orbit-container">
                <ul class="example-orbit" data-orbit>
                  <?php dynamic_sidebar("start-page-slider"); ?>
                </ul>
              </div>
            </div>
        </div><!-- /.row -->

        <div class="main-content row">

            <div class="sidebar large-4 columns">
              <div class="search-container row">
                  <div class="search-inputs large-12 columns">
                      <input type="text" placeholder="Vad letar du efter?" name="search"/>
                      <input type="submit" value="Sök">
                  </div>
              </div><!-- /.search-container -->

              <?php dynamic_sidebar("left-sidebar"); ?>
              <?php Helsingborg_sidebar_menu(); ?>

            </div><!-- /.sidebar-left -->

            <section class="news-section large-8 columns">
                <h1 class="section-title">Aktuellt i Helsingborg stad</h1>

                <div class="divider fade">
                    <div class="upper-divider"></div>
                    <div class="lower-divider"></div>
                </div>

                <?php /* Start listing the news */ ?>
                <?php dynamic_sidebar("start-page-news-listing"); ?>

            </section>
    </div><!-- /.main-content -->

        <div class="lower-content row">
            <div class="sidebar large-4 columns">
              <?php dynamic_sidebar("left-sidebar-bottom"); ?>
            </div>

            <section class="large-8 columns">
              <ul class="block-list news-block-list large-block-grid-3 medium-block-grid-3 small-block-grid-2">
                <li>
                  <img src="http://www.placehold.it/330x270" alt="alt-text"/>
                </li>
                <li>
                  <img src="http://www.placehold.it/330x270" alt="alt-text"/>
                </li>
                <li>
                  <img src="http://www.placehold.it/330x270" alt="alt-text"/>
                </li>
                <li>
                  <img src="http://www.placehold.it/330x270" alt="alt-text"/>
                </li>
                <li>
                  <img src="http://www.placehold.it/330x270" alt="alt-text"/>
                </li>
                <li>
                  <img src="http://www.placehold.it/330x270" alt="alt-text"/>
                </li>
              </ul>
            </section>
        </div><!-- /.lower-content -->
    </div>  <!-- /.main-area -->

    <div class="sidebar large-3 columns">
        <div class="row">

          <?php /* Start listing the news */ ?>
          <?php dynamic_sidebar("right-sidebar"); ?>

            <div class="news-widget large-12 widget medium-6 columns">
                <div class="widget-content">

                    <h2 class="widget-title">Fler nyheter</h2>

                    <div class="divider">
                        <div class="upper-divider"></div>
                        <div class="lower-divider"></div>
                    </div>

                    <ul class="news-list">
                        <li>
                            <a href="#">Tårtkalas i tågaparken</a>
                            <span class="date">idag 13:00</span>
                        </li>
                        <li>
                            <a href="#">Bakom kulisserna på stadsarkivet</a>
                            <span class="date">idag 15:00</span>
                        </li>
                        <li>
                            <a href="#">Samhällsåret - en antology med filmer inför valet</a>
                            <span class="date">2014-09-03</span>
                        </li>
                        <li>
                            <a href="#">Från ärans fält till slakterifabriken</a>
                            <span class="date">2014-09-03</span>

                        </li>
                        <li>
                            <a href="#">Nära leran - Sommarutställning på Keramiskt center</a>
                            <span class="date">2014-09-04</span>

                        </li>
                    </ul>

                    <a href="#" class="read-more">Fler evenemang</a>

                </div><!-- /.widget-content -->
            </div><!-- /.widget -->

          <div class="quick-links-widget widget large-12 medium-6 columns">
                <div class="widget-content">
                    <h2 class="widget-title">Hitta snabbt</h2>

                    <div class="divider">
                        <div class="upper-divider"></div>
                        <div class="lower-divider"></div>
                    </div>

                    <ul class="quick-links-list">
                        <li>
                            <a href="#">Budgetrådgivning</a>
                        </li>
                        <li>
                            <a href="#">Gymnasieskolor</a>
                        </li>
                        <li>
                            <a href="#">Kartor</a>
                        </li>
                        <li>
                            <a href="#">Konsumentrådgivning</a>
                        </li>
                        <li>
                            <a href="#">Lediga jobb</a>
                        </li>
                        <li>
                            <a href="#">Ombud för funktionsnedsatta</a>
                        </li>
                    </ul>

                </div><!-- /.widget-content -->
        </div><!-- /.widget -->
    </div><!-- /.rows -->
</div><!-- /.sidebar -->

</div>
</div><!-- /.main-site-container -->

<?php get_footer(); ?>
