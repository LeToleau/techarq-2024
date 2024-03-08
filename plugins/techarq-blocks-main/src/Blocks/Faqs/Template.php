<?php
/**
 * A custom block to display Frecuently Asked Questions.
 * 
 * @package TecharqBlocks
 */
  use TecharqBlocks\Helpers\PlaceholderHelper;

  $techarq__headline = PlaceholderHelper::placeholder('techarq_faqs_headline', 'Add a Headline');    
  $techarq_bottom_line = PlaceholderHelper::placeholder('techarq_faqs_bottom_line', 'Add a Bottom Line');;
  $techarq_button = PlaceholderHelper::placeholder('techarq_faqs_button', 'Add a Button');
?>

<div class="techarq-block faqs">
    <div class="faqs-container ms-wrapper">
        <div class="faqs-area">
            <?php if ($techarq__headline) : ?>
                <h2 class="techarq-title"><?php echo $techarq__headline; ?></h2>
            <?php endif; ?>
            <ul class="accordion">
                <?php if(have_rows('techarq_faqs')) :
                    while(have_rows('techarq_faqs')) : the_row();
                    $question = PlaceholderHelper::placeholder('question', 'Add a Question', true);
                    $answer = PlaceholderHelper::placeholder('answer', 'Add an Answer', true); ?>
                    <li>
                        <div class="question">
                            <span>
                                <?php echo esc_html($question); ?>
                            </span>
                        </div>
                        <div class="accordion-content">
                            <div class="wysiwyg">
                                <?php echo $answer; ?>
                            </div>
                        </div>
                    </li>
                <?php endwhile;
                elseif (is_admin()) : ?>
                    <div class="services-placeholder" style="padding: 50px 0;">
                        <span>Start adding FAQs by clicking on the pencil button!</span>
                        <img src="<?php echo plugins_url('/techarq-blocks/assets/icons/pencil.png'); ?>" height="40" width="40">
                    </div>
                <?php endif; ?>
            </ul>

            <!--accordion-->
            <div class="heading-block">
                <?php if ($techarq_bottom_line) : ?>
                    <h4 class="subheadline"><?php echo $techarq_bottom_line; ?></h4>
                <?php endif; ?>
                <?php if($techarq_button) :
                    $button_array = is_array($techarq_button); ?>
                    <a href="<?php echo $button_array ? esc_url($techarq_button['url']) : ''; ?>" 
                    target="<?php echo $button_array ? esc_attr($techarq_button['target']) : ''; ?>" 
                    class="button button--primary <?php echo !$button_array && !is_admin() ? 'd-none' : ''; ?>">
                        <?php echo $button_array ? esc_html($techarq_button['title']) : $techarq_button; ?>
                    </a>
                <?php endif; ?>  
            </div>
        </div>
    </div>
    <!--ms wrapper-->
</div>
    