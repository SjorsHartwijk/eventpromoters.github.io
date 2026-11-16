<?php
/**
 * Front page: landing page from the redesign.
 *
 * Teksten voor hero, cijfers, over ons en contact zijn aan te passen via
 * Weergave → Customizer → Eventpromoters. Diensten, doelgroepen en aanpak
 * zijn aan te passen via de filters hieronder (bijv. in een child theme).
 *
 * @package Eventpromoters
 */

get_header();

$ep_audiences = apply_filters(
	'eventpromoters_audiences',
	array(
		array( 'Evenementen', 'Van clubnacht tot conferentie: meer zichtbaarheid en meer kaartverkoop.' ),
		array( 'Artiesten', 'Een sterkere online aanwezigheid en een fanbase die blijft komen.' ),
		array( 'Festivals', 'Campagnes die opbouwen van aankondiging tot het laatste ticket.' ),
	)
);

$ep_services = apply_filters(
	'eventpromoters_services',
	array(
		array( 'Digital Marketing', 'Strategieën om je online aanwezigheid te versterken.' ),
		array( 'Web Development', 'Professionele websites die indruk maken.' ),
		array( 'Online Advertising', 'Gerichte advertenties voor maximale impact.' ),
		array( 'Content Creation', 'Creatieve content die je publiek inspireert.' ),
	)
);

$ep_steps = apply_filters(
	'eventpromoters_steps',
	array(
		array( 'Doelgroep & strategie', 'Doelgroep analyse en strategiebepaling.' ),
		array( 'Concept', 'Creatieve conceptontwikkeling.' ),
		array( 'Campagnes', 'Gerichte advertentiecampagnes.' ),
		array( 'Content', 'Content creatie en planning.' ),
		array( 'Optimalisatie', 'Continue optimalisatie tijdens de campagne.' ),
		array( 'Rapportage', 'Uitgebreide rapportage en analyses.' ),
	)
);

$ep_ticket_items = array( 'Doelgroep & strategie', 'Campagnes & content', 'Optimalisatie & rapportage' );
?>

<section class="hero">
	<div class="hero__dots" aria-hidden="true"></div>
	<div class="wrap hero__grid">
		<div>
			<p class="eyebrow" data-enter style="--i:0"><?php echo esc_html( eventpromoters_mod( 'hero_eyebrow' ) ); ?></p>
			<h1 class="d hero__title">
				<span class="hero__line" data-enter style="--i:1"><?php echo esc_html( eventpromoters_mod( 'hero_title' ) ); ?></span>
				<span class="hero__line" data-enter style="--i:2"><span class="hero__highlight"><?php echo esc_html( eventpromoters_mod( 'hero_highlight' ) ); ?></span></span>
			</h1>
			<p class="hero__lead" data-enter style="--i:3"><?php echo esc_html( eventpromoters_mod( 'hero_text' ) ); ?></p>
			<div class="btn-row" data-enter style="--i:4">
				<a href="#contact" class="btn btn--indigo"><?php echo esc_html( eventpromoters_mod( 'cta_label' ) ); ?></a>
				<a href="#diensten" class="btn btn--outline"><?php esc_html_e( 'Bekijk onze diensten', 'eventpromoters' ); ?></a>
			</div>
		</div>

		<div class="ticket" aria-hidden="true" data-enter-settle>
			<div class="ticket__top"><span><?php bloginfo( 'name' ); ?></span><span>Admit one</span></div>
			<div class="d ticket__title"><?php esc_html_e( 'Jouw event', 'eventpromoters' ); ?></div>
			<ul class="check-list">
				<?php foreach ( $ep_ticket_items as $ep_item ) : ?>
					<li><?php echo eventpromoters_icon( 'check' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?><?php echo esc_html( $ep_item ); ?></li>
				<?php endforeach; ?>
			</ul>
			<div class="ticket__perforation"></div>
			<div class="ticket__bottom"><span><?php esc_html_e( 'Resultaat', 'eventpromoters' ); ?></span><span class="d stamp"><?php esc_html_e( 'Uitverkocht', 'eventpromoters' ); ?></span></div>
		</div>
	</div>
</section>

<section class="stats" aria-label="<?php esc_attr_e( 'Cijfers', 'eventpromoters' ); ?>">
	<div class="wrap">
		<dl class="stats__box">
			<?php for ( $ep_i = 1; $ep_i <= 4; $ep_i++ ) : ?>
				<?php
				$ep_value = eventpromoters_mod( "stat_{$ep_i}_value" );
				if ( '' === $ep_value ) {
					continue;
				}
				?>
				<div class="stat">
					<dt class="stat__label"><?php echo esc_html( eventpromoters_mod( "stat_{$ep_i}_label" ) ); ?></dt>
					<dd class="d stat__value"><?php echo esc_html( $ep_value ); ?></dd>
				</div>
			<?php endfor; ?>
		</dl>
	</div>
</section>

<section id="voor-wie" class="section section--voor-wie">
	<div class="wrap">
		<p class="eyebrow"><?php esc_html_e( 'Voor wie', 'eventpromoters' ); ?></p>
		<h2 class="d section__title"><?php esc_html_e( 'Voor iedereen die iets te vieren heeft', 'eventpromoters' ); ?></h2>
		<p class="section__intro"><?php esc_html_e( 'Of je nu een zaal, een podium of een heel weiland wilt vullen.', 'eventpromoters' ); ?></p>
		<div class="grid grid--3">
			<?php foreach ( $ep_audiences as $ep_n => $ep_audience ) : ?>
				<?php $ep_photo = eventpromoters_mod_image( 'audience_image_' . ( $ep_n + 1 ), '(min-width: 1160px) 360px, (min-width: 700px) 45vw, 100vw' ); ?>
				<article class="card card--accent<?php echo $ep_photo ? ' card--photo' : ''; ?>">
					<?php if ( $ep_photo ) : ?>
						<figure class="card__media"><?php echo $ep_photo; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- core image markup. ?></figure>
					<?php endif; ?>
					<h3 class="d card__title"><?php echo esc_html( $ep_audience[0] ); ?></h3>
					<p><?php echo esc_html( $ep_audience[1] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section id="diensten" class="section section--diensten">
	<div class="wrap">
		<p class="eyebrow"><?php esc_html_e( 'Diensten', 'eventpromoters' ); ?></p>
		<h2 class="d section__title section__title--spaced"><?php esc_html_e( 'Onze diensten', 'eventpromoters' ); ?></h2>
		<div class="grid grid--2">
			<?php foreach ( $ep_services as $ep_n => $ep_service ) : ?>
				<article class="card">
					<div class="d card__num"><?php echo esc_html( str_pad( (string) ( $ep_n + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></div>
					<h3 class="d card__title"><?php echo esc_html( $ep_service[0] ); ?></h3>
					<p><?php echo esc_html( $ep_service[1] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php $ep_statement = eventpromoters_mod( 'statement_text' ); ?>
<?php if ( '' !== trim( $ep_statement ) ) : ?>
	<section class="statement" data-statement>
		<div class="statement__sticky">
			<div class="wrap">
				<p class="d statement__text"><?php echo eventpromoters_words( $ep_statement ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped per word. ?></p>
			</div>
		</div>
	</section>
<?php endif; ?>

<section id="aanpak" class="section section--dark">
	<div class="wrap">
		<p class="eyebrow eyebrow--mint"><?php esc_html_e( 'Onze aanpak', 'eventpromoters' ); ?></p>
		<h2 class="d section__title"><?php esc_html_e( 'Het draaiboek', 'eventpromoters' ); ?></h2>
		<p class="section__intro"><?php esc_html_e( 'Zoals elk goed event: vooraf doordacht, onderweg bijgestuurd.', 'eventpromoters' ); ?></p>
		<ol class="steps">
			<?php foreach ( $ep_steps as $ep_n => $ep_step ) : ?>
				<li class="step">
					<span class="d step__num" aria-hidden="true"><?php echo esc_html( str_pad( (string) ( $ep_n + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
					<h3 class="step__title"><?php echo esc_html( $ep_step[0] ); ?></h3>
					<p><?php echo esc_html( $ep_step[1] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>

<section id="over-ons" class="section section--lavender">
	<div class="wrap split">
		<div>
			<p class="eyebrow"><?php esc_html_e( 'Over ons', 'eventpromoters' ); ?></p>
			<h2 class="d section__title"><?php echo esc_html( eventpromoters_mod( 'about_title' ) ); ?></h2>
		</div>
		<div>
			<p class="lead"><?php echo esc_html( eventpromoters_mod( 'about_text' ) ); ?></p>
			<a href="#contact" class="btn btn--navy"><?php esc_html_e( 'Neem contact op', 'eventpromoters' ); ?></a>
		</div>
	</div>
	<?php $ep_about_photo = eventpromoters_mod_image( 'about_image', '(min-width: 1160px) 1112px, 100vw' ); ?>
	<?php if ( $ep_about_photo ) : ?>
		<div class="wrap">
			<figure class="about__photo"><?php echo $ep_about_photo; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- core image markup. ?></figure>
		</div>
	<?php endif; ?>
</section>

<?php
// Optional extra content from the page set as homepage (Instellingen → Lezen).
while ( is_page() && have_posts() ) :
	the_post();
	if ( '' !== trim( get_the_content() ) ) :
		?>
		<section class="section">
			<div class="wrap entry-content">
				<?php the_content(); ?>
			</div>
		</section>
		<?php
	endif;
endwhile;

get_template_part( 'template-parts/contact' );

get_footer();
