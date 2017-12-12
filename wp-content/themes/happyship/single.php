<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Example 2</title>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/template-bill/style.css" media="all" />
  </head>
  <body>
    <?php if (have_posts()): ?> 

    	<?php  while (have_posts()) : the_post(); ?>

			<?php get_template_part('content','bill'); ?>

		<?php endwhile; ?>

   	<?php endif; ?>
    <footer>
      Invoice was created on a computer and is valid without the signature and seal.
    </footer>
  </body>
</html>