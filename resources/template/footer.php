            </section><!-- content-->
            <footer class="site-footer">
                <span class="site-footer__mark"><?= $footer_disclaimer ?></span>

                <aside class="languages-box" hidden>
                    <input type="hidden" name="defaultLang" value ="<?= DEFAULT_LANG ?>">
                    <input type="hidden" name="languages" value="<?= implode(',', LANG) ?>">
                </aside>

            </footer>

            <?php if(!isset($no_footer_js)) : ?><script src="/assets/js/script.js"></script> <?php endif; ?>

    </div><!-- container-->
</body>
</html>