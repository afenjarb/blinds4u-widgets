<?php
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;

class Customizable_Title_Widget extends Widget_Base {

    public function get_name() {
        return 'customizable_title';
    }

    public function get_title() {
        return __('כותרת עם פס', 'custom-title-widget');
    }

    
public function get_icon() {
    return 'eicon-t-letter';
}

    public function get_categories() {
        return ['basic'];
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Title', 'custom-title-widget'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title_text',
            [
                'label' => __('טקסט כותרת', 'custom-title-widget'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Your Title Here', 'custom-title-widget'),
            ]
        );

        $this->add_control(
            'html_tag',
            [
                'label' => __('תגית HTML', 'custom-title-widget'),
                'type' => Controls_Manager::SELECT,
                'default' => 'h2',
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'p' => 'p',
                    'div' => 'div',
                    'span' => 'span',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => __('טיפוגרפיה', 'custom-title-widget'),
                'selector' => '{{WRAPPER}} .blinds-custom-title',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => __('טיפוגרפיה', 'custom-title-widget'),
                'selector' => '{{WRAPPER}} .blinds-custom-title',
                'selectors' => [
                    '{{WRAPPER}} .blinds-custom-title' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .blinds-title-underline-svg' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'alignment',
            [
                'label' => __('יישור טקסט', 'custom-title-widget'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => __('Right', 'custom-title-widget'),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'center' => [
                        'title' => __('Center', 'custom-title-widget'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => __('Left', 'custom-title-widget'),
                        'icon' => 'eicon-text-align-left',
                    ],
                ],
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .blinds-custom-title-wrapper' => 'align-items: {{VALUE}};',
                    '{{WRAPPER}} .blinds-custom-title-container' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('צבע כותרת', 'custom-title-widget'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blinds-custom-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'svg_fill_color',
            [
                'label' => __('צבע פס', 'custom-title-widget'),
                'type' => Controls_Manager::COLOR,
                'default' => '#a995c4',
                'selectors' => [
                    '{{WRAPPER}} .blinds-title-underline-svg path' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    private function get_frontend_script($widget_id) {
        ob_start(); ?>
        <script>
        (function() {
            function adjustUnderline() {
                const container = document.getElementById("<?php echo esc_js($widget_id); ?>");
                if (!container) return;
                
                const title = container.querySelector(".blinds-custom-title");
                const svg = container.nextElementSibling;
                
                if (title && svg) {
                    const titleWidth = title.offsetWidth;
                    const fontSize = parseFloat(window.getComputedStyle(title).fontSize);
                    
                    const svgWidth = titleWidth;
                    const svgHeight = fontSize * 0.4;
                    const marginTop = fontSize * -0.468;
                    
                    svg.style.width = svgWidth + "px";
                    svg.style.height = svgHeight + "px";
                    svg.style.marginTop = marginTop + "px";
                }
            }
            
            adjustUnderline();
            window.addEventListener("resize", adjustUnderline);
            setTimeout(adjustUnderline, 100);
            
            if (typeof elementorFrontend !== "undefined") {
                elementorFrontend.hooks.addAction("frontend/element_ready/widget", adjustUnderline);
            }
        })();
        </script>
        <?php
        return ob_get_clean();
    }

    private function get_editor_script() {
        ob_start(); ?>
        <script>
        (function() {
            function initializeEditor() {
                function adjustUnderline() {
                    const containers = document.querySelectorAll('.blinds-custom-title-container');
                    containers.forEach(container => {
                        const title = container.querySelector(".blinds-custom-title");
                        const svg = container.nextElementSibling;
                        
                        if (title && svg) {
                            const titleWidth = title.offsetWidth;
                            const fontSize = parseFloat(window.getComputedStyle(title).fontSize);
                            
                            const svgWidth = titleWidth;
                            const svgHeight = fontSize * 0.4;
                            const marginTop = fontSize * -0.468;
                            
                            svg.style.width = svgWidth + "px";
                            svg.style.height = svgHeight + "px";
                            svg.style.marginTop = marginTop + "px";
                        }
                    });
                }

                adjustUnderline();
                elementor.channels.editor.on('change', adjustUnderline);
                elementor.channels.preview.on('change', adjustUnderline);
                elementor.channels.typography.on('change', adjustUnderline);

                const observer = new MutationObserver(adjustUnderline);
                observer.observe(document.body, {
                    childList: true,
                    subtree: true,
                    attributes: true,
                    attributeFilter: ['style', 'class']
                });

                window.addEventListener("resize", adjustUnderline);
            }

            if (window.elementor) {
                initializeEditor();
            } else {
                document.addEventListener('elementor/init', initializeEditor, { once: true });
            }
        })();
        </script>
        <?php
        return ob_get_clean();
    }

    private function render_title_html($settings, $widget_id) {
        ?>
        <div class="blinds-custom-title-align">
            <<?php echo esc_html($settings['html_tag']); ?> class="blinds-custom-title-wrapper">
                <div class="blinds-custom-title-container" id="<?php echo esc_attr($widget_id); ?>">
                    <span class="blinds-custom-title"><?php echo esc_html($settings['title_text']); ?></span>
                </div>
                <svg class="blinds-title-underline-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 787.999 50.127" preserveAspectRatio="none">
                    <path id="customizable-title-line" data-name="customizable title line" d="M783.452,114.069c24.715-.6,52.32-1.231,24.312-29.568S44.148,79.635,44.148,79.635s-31.457,36.577,4.99,40.178,734.314-5.744,734.314-5.744" transform="translate(-31.536 -70.511)"/>
                </svg>
            </<?php echo esc_html($settings['html_tag']); ?>>
        </div>
        <?php
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $widget_id = 'custom-title-' . $this->get_id();
        
        // Render HTML
        $this->render_title_html($settings, $widget_id);
        
        // Add appropriate script based on context
        if (!\Elementor\Plugin::$instance->editor->is_edit_mode()) {
            echo $this->get_frontend_script($widget_id);
        } else {
            echo $this->get_editor_script();
        }
    }
}