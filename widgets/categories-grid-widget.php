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
            'show_banner',
            [
                'label' => 'הצג באנר',
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => 'כן',
                'label_off' => 'לא',
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label' => 'כותרת',
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'כותרת',
            ]
        );

        $repeater->add_control(
            'content',
            [
                'label' => 'תוכן',
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => 'תוכן',
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
            'banner_text_small',
            [
                'label' => 'טקסט קטן לבאנר',
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => 'עד',
                'rows' => 3,
                'condition' => [
                    'show_banner' => 'yes',
                ],
            ]
        );

        $repeater->add_control(
            'banner_text_large',
            [
                'label' => 'טקסט גדול לבאנר',
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => '40% הנחה',
                'rows' => 3,
                'condition' => [
                    'show_banner' => 'yes',
                ],
            ]
        );

        $repeater->add_control(
            'banner_gradient_start',
            [
                'label' => 'צבע באנר ראשון',
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#022d82',
                'condition' => [
                    'show_banner' => 'yes',
                ],
                'global' => [
                    'active' => false
                ],
            ]
        );
        
        $repeater->add_control(
            'banner_gradient_end',
            [
                'label' => 'צבע באנר שני',
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#022d82',
                'condition' => [
                    'show_banner' => 'yes',
                ],
                'global' => [
                    'active' => false
                ],
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

        // Title Style Section
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

        // Content Style Section
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
        



    
        // FULL WIDTH ITEM
    $this->start_controls_section(
        'full_width_section',
        [
            'label' => 'פריט ברוחב מלא',
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]
    );

        //############# Full Width Item #############
        $this->add_control(
            'show_full_width_item',
            [
                'label' => 'הצג שורה מלאה',
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => 'כן',
                'label_off' => 'לא',
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'full_width_title',
            [
                'label' => 'כותרת',
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'כותרת',
                'condition' => [
                    'show_full_width_item' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'full_width_content',
            [
                'label' => 'תוכן',
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => 'תוכן',
                'condition' => [
                    'show_full_width_item' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'full_width_link',
            [
                'label' => 'קישור',
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => 'https://your-link.com',
                'default' => [
                    'url' => '',
                    'is_external' => false,
                    'nofollow' => false,
                ],
                'condition' => [
                    'show_full_width_item' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'full_width_background',
            [
                'label' => 'תמונת רקע',
                'type' => \Elementor\Controls_Manager::MEDIA,
                'devices' => ['desktop', 'tablet', 'mobile'],
                'condition' => [
                    'show_full_width_item' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'full_width_show_banner',
            [
                'label' => 'הצג באנר',
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => 'כן',
                'label_off' => 'לא',
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'show_full_width_item' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'full_width_banner_text_small',
            [
                'label' => 'טקסט קטן לבאנר',
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => 'עד',
                'rows' => 3,
                'condition' => [
                    'show_full_width_item' => 'yes',
                    'full_width_show_banner' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'full_width_banner_text_large',
            [
                'label' => 'טקסט גדול לבאנר',
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => '40% הנחה',
                'rows' => 3,
                'condition' => [
                    'show_full_width_item' => 'yes',
                    'full_width_show_banner' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'full_width_banner_gradient_start',
            [
                'label' => 'צבע באנר ראשון',
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#4266ae',
                'condition' => [
                    'show_full_width_item' => 'yes',
                    'full_width_show_banner' => 'yes',
                ],
                'global' => [
                    'active' => false
                ],
            ]
        );
        
        $this->add_control(
            'full_width_banner_gradient_end',
            [
                'label' => 'צבע באנר שני',
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#022d82',
                'condition' => [
                    'show_full_width_item' => 'yes',
                    'full_width_show_banner' => 'yes',
                ],
                'global' => [
                    'active' => false
                ],
            ]
        );

        $this->end_controls_section();

        // ############# Regular Banner Text Style Section #############
        $this->start_controls_section(
            'banner_text_style_section',
            [
                'label' => 'סגנון טקסט באנר',
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_control(
            'banner_position_heading',
            [
                'label' => 'מיקום טקסטים בבאנר',
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        
        $this->add_responsive_control(
            'banner_offset_x',
            [
                'label' => 'מיקום X',
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => -60,
                ],
                'tablet_default' => [
                    'unit' => 'px',
                    'size' => -60,
                ],
                'mobile_default' => [
                    'unit' => 'px',
                    'size' => -60,
                ],
                'selectors' => [
                    '{{WRAPPER}} .blinds-category-grid-banner-texts' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'banner_offset_y',
            [
                'label' => 'מיקום Y',
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => -20,
                ],
                'tablet_default' => [
                    'unit' => 'px',
                    'size' => -20,
                ],
                'mobile_default' => [
                    'unit' => 'px',
                    'size' => -20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .blinds-category-grid-banner-texts' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_control(
            'small_text_style_heading',
            [
                'label' => 'טקסט קטן',
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        
        $this->add_responsive_control(
            'small_text_font_size',
            [
                'label' => 'גודל טקסט',
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 26,
                ],
                'tablet_default' => [
                    'unit' => 'px',
                    'size' => 22,
                ],
                'mobile_default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .blinds-category-grid-small-text' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_control(
            'large_text_style_heading',
            [
                'label' => 'טקסט גדול',
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        
        $this->add_responsive_control(
            'large_text_font_size',
            [
                'label' => 'גודל טקסט',
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 55,
                ],
                'tablet_default' => [
                    'unit' => 'px',
                    'size' => 45,
                ],
                'mobile_default' => [
                    'unit' => 'px',
                    'size' => 40,
                ],
                'selectors' => [
                    '{{WRAPPER}} .blinds-category-grid-large-text' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        // ############# Full Width Banner Text Style Section #############
        $this->start_controls_section(
            'full_width_banner_text_style_section',
            [
                'label' => 'סגנון טקסט באנר ברוחב מלא',
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_control(
            'full_width_banner_position_heading',
            [
                'label' => 'מיקום טקסטים בבאנר',
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'full_width_banner_offset_x',
            [
                'label' => 'מיקום X',
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => -60,
                ],
                'tablet_default' => [
                    'unit' => 'px',
                    'size' => -60,
                ],
                'mobile_default' => [
                    'unit' => 'px',
                    'size' => -60,
                ],
                'selectors' => [
                    '{{WRAPPER}} .blinds-category-item-link.full-width .blinds-category-grid-banner-texts' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'full_width_banner_offset_y',
            [
                'label' => 'מיקום Y',
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => -20,
                ],
                'tablet_default' => [
                    'unit' => 'px',
                    'size' => -20,
                ],
                'mobile_default' => [
                    'unit' => 'px',
                    'size' => -20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .blinds-category-item-link.full-width .blinds-category-grid-banner-texts' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'full_width_small_text_style_heading',
            [
                'label' => 'טקסט קטן',
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'full_width_small_text_font_size',
            [
                'label' => 'גודל טקסט',
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 26,
                ],
                'tablet_default' => [
                    'unit' => 'px',
                    'size' => 22,
                ],
                'mobile_default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .blinds-category-item-link.full-width .blinds-category-grid-small-text' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'full_width_large_text_style_heading',
            [
                'label' => 'טקסט גדול',
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'full_width_large_text_font_size',
            [
                'label' => 'גודל טקסט',
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 55,
                ],
                'tablet_default' => [
                    'unit' => 'px',
                    'size' => 45,
                ],
                'mobile_default' => [
                    'unit' => 'px',
                    'size' => 40,
                ],
                'selectors' => [
                    '{{WRAPPER}} .blinds-category-item-link.full-width .blinds-category-grid-large-text' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
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
                
                $show_banner = isset($item['show_banner']) && $item['show_banner'] === 'yes';
                
                if ($show_banner) {
                    $start_color = !empty($item['banner_gradient_start']) ? $item['banner_gradient_start'] : '#4266ae';
                    $end_color = !empty($item['banner_gradient_end']) ? $item['banner_gradient_end'] : '#022d82';
                    $banner_svg = $this->generate_banner_svg($start_color, $end_color, $index);
                }
            ?>
                <a href="<?php echo esc_url($url); ?>"<?php echo $target . $nofollow; ?> class="blinds-category-item-link">
                    <div class="blinds-category-item" style="background-image: url('<?php echo $item['background_image']['url']; ?>');">
                        <?php if ($show_banner) : ?>
                            <div class="blinds-category-banner">
                                <div class="blinds-category-grid-banner-texts">
                                    <span class="blinds-category-grid-small-text"><?php echo wp_kses_post($item['banner_text_small']); ?></span>
                                    <span class="blinds-category-grid-large-text"><?php echo wp_kses_post($item['banner_text_large']); ?></span>
                                </div>
                                <img src="<?php echo esc_attr($banner_svg); ?>" alt="Category Banner" class="blinds-category-grid-banner-svg">
                            </div>
                        <?php endif; ?>
                        <h3 class="blinds-category-item-title"><?php echo $item['title']; ?></h3>
                        <div class="blinds-category-item-content"><?php echo $item['content']; ?></div>
                    </div>
                </a>
            <?php endforeach; ?>

                <?php if ($settings['show_full_width_item'] === 'yes') : 
                    $full_width_target = $settings['full_width_link']['is_external'] ? ' target="_blank"' : '';
                    $full_width_nofollow = $settings['full_width_link']['nofollow'] ? ' rel="nofollow"' : '';
                    $full_width_url = $settings['full_width_link']['url'] ? $settings['full_width_link']['url'] : '#';
                    
                    $show_banner = $settings['full_width_show_banner'] === 'yes';
                    
                    if ($show_banner) {
                        $start_color = !empty($settings['full_width_banner_gradient_start']) ? $settings['full_width_banner_gradient_start'] : '#4266ae';
                        $end_color = !empty($settings['full_width_banner_gradient_end']) ? $settings['full_width_banner_gradient_end'] : '#022d82';
                        $banner_svg = $this->generate_banner_svg($start_color, $end_color, 'full-width');
                    }

                    // Prepare background image classes and styles
                    $bg_classes = ['blinds-category-item'];
                    $custom_styles = '';

                    if (!empty($settings['full_width_background']['url'])) {
                        $custom_styles .= "background-image: url('" . $settings['full_width_background']['url'] . "');";
                    }

                    if (!empty($settings['full_width_background_tablet']['url'])) {
                        $bg_classes[] = 'has-tablet-bg';
                        $custom_styles .= "--tablet-bg: url('" . $settings['full_width_background_tablet']['url'] . "');";
                    }

                    if (!empty($settings['full_width_background_mobile']['url'])) {
                        $bg_classes[] = 'has-mobile-bg';
                        $custom_styles .= "--mobile-bg: url('" . $settings['full_width_background_mobile']['url'] . "');";
                    }
                    ?>
                    <a href="<?php echo esc_url($full_width_url); ?>"<?php echo $full_width_target . $full_width_nofollow; ?> class="blinds-category-item-link full-width">
                        <div class="<?php echo implode(' ', $bg_classes); ?>" style="<?php echo $custom_styles; ?>">
                            <?php if ($show_banner) : ?>
                                <div class="blinds-category-banner">
                                    <div class="blinds-category-grid-banner-texts">
                                        <span class="blinds-category-grid-small-text"><?php echo wp_kses_post($settings['full_width_banner_text_small']); ?></span>
                                        <span class="blinds-category-grid-large-text"><?php echo wp_kses_post($settings['full_width_banner_text_large']); ?></span>
                                    </div>
                                    <img src="<?php echo esc_attr($banner_svg); ?>" alt="Category Banner" class="blinds-category-grid-banner-svg">
                                </div>
                            <?php endif; ?>
                            <h3 class="blinds-category-item-title"><?php echo $settings['full_width_title']; ?></h3>
                            <div class="blinds-category-item-content"><?php echo $settings['full_width_content']; ?></div>
                        </div>
                    </a>
                <?php endif; ?>

        </div>
        <?php
    }

}