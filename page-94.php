<?php
/* Template Name: Croche Contato */

get_header(); ?>
<div id="header-headline">
  <div class="headline-text">
    <h1 class="entry-title font-lora">Contato</h1>
  </div>
</div>

<div class="content-wrap">
  <div id="content" class="section group">
    <div class="col span_8_of_12">
      <article class="post-single contact-page">
        <header>
          <p class="post-title font-lora">Entre em contato conosco!</p>
        </header>
        <?php 
          if ( have_posts() ) {
	        while ( have_posts() ) {
		      the_post();
		      the_content();
	        }
          }
	    ?>
      </article>
    </div>
    <div class="sidebar col span_4_of_12">
      <?php include get_template_directory().'/sidebar.php' ?>
    </div>
  </div>
</div>

<?php get_footer(); ?>