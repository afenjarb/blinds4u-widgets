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

    private function generate_banner_svg($start_color, $end_color, $index) {
        // Remove '#' from color codes if present
        $start_color = ltrim($start_color, '#');
        $end_color = ltrim($end_color, '#');
        
        $svg = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="248.64" height="248.625" viewBox="0 0 248.64 248.625">
            <defs>
                <linearGradient id="banner-gradient-' . $index . '" x1="0.57" y1="0.558" x2="0.175" y2="0.179" gradientUnits="objectBoundingBox">
                    <stop offset="0" stop-color="#' . $start_color . '"/>
                    <stop offset="1" stop-color="#' . $end_color . '"/>
                </linearGradient>
            </defs>
            <g transform="translate(-14.201 -568.582)">
                <path d="M241.053.251C220.964,20.34,235.428,34.8,215.339,54.892S180.786,60.518,160.7,80.607s-5.624,34.551-25.712,54.639-34.551,5.624-54.639,25.712-5.622,34.549-25.709,54.636S20.088,221.216,0,241.3V11.675A11.675,11.675,0,0,1,11.688,0Z" transform="translate(14.977 569.082)" fill="url(#banner-gradient-' . $index . ')"/>
                <path d="M0,246.918V238.7a40.593,40.593,0,0,1,12.745-8.267,60.959,60.959,0,0,1,13.145-3.193l.017,0c8.514-1.386,17.318-2.82,27.383-12.885s11.5-18.867,12.885-27.379a60.928,60.928,0,0,1,3.2-13.167,41.879,41.879,0,0,1,9.689-14.22,41.888,41.888,0,0,1,14.221-9.69,60.906,60.906,0,0,1,13.163-3.2c8.514-1.387,17.317-2.821,27.382-12.885s11.5-18.867,12.885-27.379a60.928,60.928,0,0,1,3.2-13.167,41.878,41.878,0,0,1,9.689-14.22,41.887,41.887,0,0,1,14.221-9.69,60.966,60.966,0,0,1,13.149-3.194l.012,0c8.513-1.386,17.317-2.82,27.383-12.886s11.5-18.936,12.886-27.512a64.6,64.6,0,0,1,2.9-12.463A39.944,39.944,0,0,1,238.468,0h8.465l-2.655,2.656c-8.717,8.7-9.891,15.84-11.249,24.1l-.012.072,0,.016c-1.463,8.986-3.121,19.171-14.523,30.573s-21.583,13.061-30.568,14.525l-.028,0c-8.282,1.347-15.434,2.51-24.168,11.243s-9.9,15.89-11.246,24.173l0,.019c-1.463,8.986-3.121,19.171-14.523,30.573-11.42,11.4-21.594,13.062-30.57,14.525-8.291,1.345-15.452,2.506-24.195,11.247s-9.9,15.889-11.245,24.172l0,.016c-1.464,8.988-3.124,19.175-14.524,30.576C46,229.914,35.823,231.556,26.846,233l-.075.012c-8.264,1.359-15.4,2.533-24.1,11.235L0,246.916Z" transform="translate(14.701 569.082)" fill="#fff" stroke="rgba(0,0,0,0)" stroke-width="1"/>
            </g>
        </svg>';
        
        return 'data:image/svg+xml;base64,' . base64_encode($svg);
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

        //BANNER CONTROLS
        $repeater->add_control(
            'banner_gradient_start',
            [
                'label' => 'צבע התחלתי לבאנר',
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#4266ae',  // Your original start color
            ]
        );
    
        $repeater->add_control(
            'banner_gradient_end',
            [
                'label' => 'צבע סופי לבאנר',
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#022d82',  // Your original end color
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
            <?php foreach ($settings['items'] as $index => $item) : 
                $target = $item['item_link']['is_external'] ? ' target="_blank"' : '';
                $nofollow = $item['item_link']['nofollow'] ? ' rel="nofollow"' : '';
                $url = $item['item_link']['url'] ? $item['item_link']['url'] : '#';
                
                $start_color = !empty($item['banner_gradient_start']) ? $item['banner_gradient_start'] : '#4266ae';
                $end_color = !empty($item['banner_gradient_end']) ? $item['banner_gradient_end'] : '#022d82';
                
                // Generate SVG with index for unique gradient IDs
                $banner_svg = $this->generate_banner_svg($start_color, $end_color, $index);
            ?>
                <a href="<?php echo esc_url($url); ?>"<?php echo $target . $nofollow; ?> class="blinds-category-item-link">
                    <div class="blinds-category-item" style="background-image: url('<?php echo $item['background_image']['url']; ?>');">
                        <div class="blinds-category-banner">
                            <img src="<?php echo esc_attr($banner_svg); ?>" 
                                alt="Category Banner" 
                                class="blinds-category-grid-banner-svg">
                        </div>
                        <h3 class="blinds-category-item-title"><?php echo $item['title']; ?></h3>
                        <div class="blinds-category-item-content"><?php echo $item['content']; ?></div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
        <?php
    }
}