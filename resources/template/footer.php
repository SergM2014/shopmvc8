            </section><!-- content-->
            <footer class="site-footer">
                <p class="site-footer__mark"><?= $footer_disclaimer ?></p>

                <?php include_once PATH_SITE.'/resources/customer/partials/translation.php'?>

            </footer>

            <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
           <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->
            <!-- Include all compiled plugins (below), or include individual files as needed -->
            <!--<script src="/vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>-->

            <?php if(!isset($no_footer_js)) : ?><script src="/assets/js/script.js"></script> <?php endif; ?>

    </div><!-- container-->
</body>
</html>