            </section><!-- content-->

            <footer class="site-footer">


                <aside class="languages-box" hidden>
                    <input type="hidden" name="defaultLang" value ="<?= DEFAULT_LANG ?>">
                    <input type="hidden" name="languages" value="<?= implode(',', LANG) ?>">
                </aside>

            </footer>


            <?php if (isset($_SESSION['admin'])) : ?> <script src="/assets/js/admin.js"></script> <?php endif; ?>

    </div><!-- container-->
</body>
</html>