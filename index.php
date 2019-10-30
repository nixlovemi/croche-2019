<?php
get_header();

if(is_home() || is_front_page()){
  get_template_part( "home" );
}
else if(is_single()){
  get_template_part( "template-nix-single" );
}
else if(is_tag()){
  get_template_part( "template-nix-categoryy" );
}
else if(is_category()){
  get_template_part( "template-nix-categoryy" );
}
else if(is_search()){
  get_template_part( "template-nix-categoryy" );
}
else if(is_page()){
  get_template_part( "template-nix-page" );
  // get_template_part( "template-nix-categoryy" );
}

get_footer();