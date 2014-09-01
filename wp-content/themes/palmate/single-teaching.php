<?php if (have_posts()) : the_post(); ?>

<?php echo palmate_get_the_teaching_content(); ?>

  <div class="row-fluid">
    <div class="span8">

      <article class="hentry row-fluid">
        <div class="span12">
          <div class="contentBox marginLeft">
            <div class="teachingBanner"><p>Predikning</p></div>
            <div class="paddingBoth marginTop">
              <header class="media">
                <div class="media-body">
                  <a href="/undervisningar"><h2 class="entry-title media-heading">Undervisningar</h2></a>
                  <p class="teachingMeta">2013-10-12 <br class="visible-phone" /><span class="hidden-phone">| </span>Eleonore Gustafsson</p>
                  <p class="teachingMeta">Del 2 av 4 i temat <a href="#">"Vatten är tjockare än blod"</a></p>
                </div>
  <!--              <button type="button" class="btn btn-link" data-toggle="collapse" data-target=".text_1">Visa hela</button> -->
                <div class="hideHref"><a class="ageAndTime" href="#" data-toggle="collapse" data-target=".text_1"><span>Visa hela<span class="dividerVert"></span><i class="icon-headphones"></i><span class="dividerVert"></span><i class="icon-list-alt"></i></span></a></div>
              </header>
              <div class="row-flow">
                <div class="span12">
                  <div id="sound_1" class="text_1 collapse out">
                    <hr />
                    <audio controls>
                      <source src="horse.ogg" type="audio/ogg">
                      <source src="horse.mp3" type="audio/mpeg">
                      Your browser does not support the audio element.
                    </audio>
                  </div>
                  <br />
                  <p>Predikan började med att vi tittade på tavlan ”Skriet” av Edvard Munch – så här mår människor ibland, både de som tror på Jesus och de som inte tror på Jesus. Ändå är det skillnad på ångest utan Jesus och ångest tillsammans med Jesus. Augustinus sa:</p>
                  <div id="text_1" class="text_1 collapse out"><p>”Du, o Herre, har skapat mig till dig och mitt hjärta är oroligt, till dess det finner ro i dig.” Det finns en ångest som beror på att vi inte är i kontakt med vårt ursprung, vår skapare. Ångesten kan också vara en alarmklocka som talar om för oss att något är fel. Då behöver vi ta tag i det som är fel, en synd, ett trauma, ett sår, en skadlig livsstil. I dessa fall vore det kontraproduktivt av Gud att ta bort ångesten, då försvinner ju alarmsignalen. Men så finns det en ångest som vi inte kan göra något åt, en ångest som bara är. Jesus hade ångest i Getsemane (t.ex. Mark 14:32-42) han vet hur det känns. Läs Rom 8:35-39 – vår tillvaro just nu är som ”slaktfår”, men i detta lidande kan vi triumfera, om vi är förenade med den lidande frälsaren. Ångesten tillsammans med Jesus är en ångest med hopp om befrielse. Om man har hopp mitt i ångesten kan inte rädslan ta överhand. Läs Upp 1:9, 17-18!</p></div>
                  <div id="extra_1" class="text_1 collapse out">
                    <hr />
                    <h3>Samtalsfrågor</h3>
                    <ul>
                      <li>Vad är ångest? Finns det olika sorters ångest?</li>
                      <li>Finns det en god ångest, en ångest som för oss djupare in i gemenskapen med Gud?</li>
                      <li>Varför hade Jesus ångest?</li>
                      <li>Vad innebär Rom 8:37?</li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </article>

    </div>
    <div class="span4 hidden-phone">
      <div class="hentry row-fluid">
        <div class="span12">
          <div class="contentBox marginRight paddingBoth">
            <h3>Tema två</h3>
          </div>
        </div>
      </div>
    </div>
  </div>

  <article class="hentry row-fluid">
    <div class="span12">
      <div class="contentBox marginBoth paddingBoth">
        <header>
          <a href="/undervisningar"><h2 class="entry-title">Undervisningar</h2></a>
        </header>
      </div>
    </div>
  </article>

<article id="<?php echo $post->post_name; ?>" class="hentry row-fluid">
  <div class="span12">
    <div class="contentBox marginBoth paddingBoth">
      <header>
        <a href="/undervisningar"><h1 class="entry-title">Undervisningar</h1></a>
      </header>
      <p><?php echo get_the_title(); ?></p>
      <p><?php echo get_field( 'data_source' ); ?></p>
      <p><?php echo get_field( 'event_id' ); ?></p>
      <p><?php echo get_field( 'author' ); ?></p>
      <p><?php echo get_field( 'teaching_date' ); ?></p>
      <p><?php echo get_field( 'text' ); ?></p>
      <p><?php echo get_field( 'extra_text' ); ?></p>
      <p><?php echo get_field( 'soundfile' ); ?></p>
      <p><?php echo get_field( 'theme_connection' ); ?></p>
    </div>
  </div>
</article>
<?php endif; ?>


