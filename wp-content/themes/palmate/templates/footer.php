<footer id="content-info" class="container-fluid" role="contentinfo">
  <div class="row-fluid">
    <div class="span12 paddingBoth">
      <div style="color: #888;">
        Logga in: <a style="color: #888;" href="<?php echo wp_login_url(); ?>" title="Logga in för att redigera sidor">Sidor</a> | <a style="color: #888;" href="<?php echo BACKEND_URL; ?>" title="Logga in för att redigera Event">Event</a>
      </div>
    </div>
  </div>
</footer>

<?php wp_footer(); ?>

<script>email_at_replace();</script>
