<?php
class Categories_Grid_Widget extends \Elementor\Widget_Base {
    public function get_name() {
        return 'categories_grid';
    }

    public function get_title() {
        return 'גריד קטגוריות';
    }

    public function get_icon() {
        return 'eicon-gallery-grid';
    }

    public function get_categories() {
        return ['general'];
    }

    protected function register_controls() {
        // Items Repeater
        $this->start_controls_section(
            'content_section',
            [
                'label' => 'פריטים',
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'title',
            [
                'label' => 'כותרת',
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'Item Title',
            ]
        );

        $repeater->add_control(
            'content',
            [
                'label' => 'תוכן',
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => 'Item Content',
            ]
        );

        $repeater->add_control(
            'item_link',
            [
                'label' => 'קישור',
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => 'https://your-link.com',
                'default' => [
                    'url' => '',
                    'is_external' => false,
                    'nofollow' => false,
                ],
            ]
        );

        $repeater->add_control(
            'background_image',
            [
                'label' => 'תמונת רקע',
                'type' => \Elementor\Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'items',
            [
                'label' => 'פריטים',
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->end_controls_section();

        // Title Style
        $this->start_controls_section(
            'title_style_section',
            [
                'label' => 'סגנון כותרת',
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => 'צבע כותרת',
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blinds-category-item-title' => 'color: {{VALUE}};',
                ],
                'default' => '#ffffff',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .blinds-category-item-title',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'title_text_shadow',
                'selector' => '{{WRAPPER}} .blinds-category-item-title',
            ]
        );

        $this->end_controls_section();

        // Content Style
        $this->start_controls_section(
            'content_style_section',
            [
                'label' => 'סגנון תוכן',
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => 'צבע',
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blinds-category-item-content' => 'color: {{VALUE}};',
                ],
                'default' => '#ffffff',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'selector' => '{{WRAPPER}} .blinds-category-item-content',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="blinds-categories-grid-container">
            <?php foreach ($settings['items'] as $item) : 
                $target = $item['item_link']['is_external'] ? ' target="_blank"' : '';
                $nofollow = $item['item_link']['nofollow'] ? ' rel="nofollow"' : '';
                $url = $item['item_link']['url'] ? $item['item_link']['url'] : '#';
            ?>
                <a href="<?php echo esc_url($url); ?>"<?php echo $target . $nofollow; ?> class="blinds-category-item-link">
                    <div class="blinds-category-item" style="background-image: url('<?php echo $item['background_image']['url']; ?>');">
                        <h3 class="blinds-category-item-title"><?php echo $item['title']; ?></h3>
                        <div class="blinds-category-item-content"><?php echo $item['content']; ?></div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
        <?php
    }
}