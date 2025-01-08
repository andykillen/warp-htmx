<?php do_action( 'theme_excerpt_before' ); ?>
<?php 

$_product = wc_get_product( get_the_ID() );


?>
<article class="<?php echo apply_filters('theme_product_excerpt_class', 'mt-8 grid grid-cols-1 gap-y-12 sm:grid-cols-2 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8') ?>">
    <div>
        <div class="relative">
            <a href="<?php the_permalink(); ?>">
                
                <div class="relative h-72 w-full overflow-hidden rounded-lg">
                    <?php if(has_post_thumbnail()): ?>
                        <?php the_post_thumbnail('medium', ['class' => 'h-full w-full object-cover object-center']); ?>
                    <?php else: ?>
                        <img src="<?php echo get_stylesheet_directory_uri() . "/assets/images/no-image.svg" ?>" alt="" class="h-full w-full object-cover object-center">
                    <?php endif; ?>
                </div>
                <div class="relative mt-4">
                <h3 class="text-sm font-medium text-gray-900"><?php the_title(); ?></h3>
                <p class="mt-1 text-sm text-gray-500"><?php the_excerpt() ?></p>
                </div>
            </a>
            <div class="absolute inset-x-0 top-0 flex h-72 items-end justify-end overflow-hidden rounded-lg p-4">
            <div aria-hidden="true" class="absolute inset-x-0 bottom-0 h-36 bg-gradient-to-t from-black opacity-50"></div>
            <p class="relative text-lg font-semibold text-white"><?php echo get_woocommerce_currency_symbol(); ?><?php echo $_product->get_price() ?></p>
            </div>
        </div>
        <div class="mt-6">
            <a href="?add-to-cart=<?php echo get_the_ID() ?>&quantity=1" class="relative flex items-center justify-center rounded-md border border-transparent bg-gray-100 px-8 py-2 text-sm font-medium text-gray-900 hover:bg-gray-200">Add to cart<span class="sr-only">, <?php the_title(); ?></span></a>
        </div>
    </div>
</article>
<?php do_action( 'theme_excerpt_after' ); ?>