            </section><!-- content-->

            <footer class="site-footer">


                <aside class="languages-box" hidden>
                    <input type="hidden" name="defaultLang" value ="<?= DEFAULT_LANG ?>">
                    <input type="hidden" name="languages" value="<?= implode(',', LANG) ?>">
                </aside>

            </footer>


            <?php if (isset($_SESSION['admin'])) : ?>
                <script src="/public/assets/js/admin.js"></script>
                <script src="/public/assets/js/adminUploadImage.js"></script>
            <?php endif; ?>

    </div><!-- container-->
</body>
</html>