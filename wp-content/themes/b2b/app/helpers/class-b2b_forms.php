<?php
    /**
     * @Filename: class-b2b_forms.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 21/2/2023
     */

    namespace B2B\APP\HELPERS;

    use B2B\B2b;

    /**
     * Description...
     *
     * @class B2b_Forms
     * @version 1.0
     * @since 1.0.0
     * @package b2b
     * @author Mustafa Shaaban
     */
    class B2b_Forms extends B2b_Hooks
    {

        private static ?object $instance = NULL;

        /**
         * Initialize the class and set its properties.
         *
         * @since    1.0.0
         */
        public function __construct()
        {
            parent::__construct();
        }

        /**
         * Description...
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return mixed|object|null
         */
        public static function get_instance()
        {
            $class = __CLASS__;
            if (!self::$instance instanceof $class) {
                self::$instance = new $class;
            }

            return self::$instance;
        }

        /**
         * The Form Controller
         * This function responsible fore controlling the form settings and create all form fields
         * by take them as an array and return the html form.
         *
         * @param array $form_fields
         * @param array $form_tag
         *
         * @return string
         */
        public function create_form(array $form_fields = [], array $form_tag = []): string
        {
            if (empty($form_fields)) {
                return "";
            }

            $settings = $this->sort_settings($form_fields);

            $form = $this->form_start($form_tag);
            foreach ($settings as $key => $field) {
                if ($field['type'] === 'text' || $field['type'] === 'email' || $field['type'] === 'password' || $field['type'] === 'number' || $field['type'] === 'tel') {
                    $form .= $this->std_inputs($field);
                } elseif ($field['type'] === 'hidden') {
                    $form .= $this->create_hidden_inputs($field);
                } elseif ($field['type'] === 'file') {
                    $form .= $this->file_inputs($field);
                } elseif ($field['type'] === 'checkbox') {
                    $form .= $this->checkbox_inputs($field);
                } elseif ($field['type'] === 'radio') {
                    $form .= $this->radio_inputs($field);
                } elseif ($field['type'] === 'switch') {
                    $form .= $this->switch_inputs($field);
                } elseif ($field['type'] === 'textarea') {
                    $form .= $this->textarea_inputs($field);
                } elseif ($field['type'] === 'select') {
                    $form .= $this->selectBox_inputs($field);
                } elseif ($field['type'] === 'nonce') {
                    $form .= $this->create_nonce($field);
                } elseif ($field['type'] === 'submit' || $field['type'] === 'button') {
                    $form .= $this->form_submit_button($field);
                } elseif ($field['type'] === 'html') {
                    $form .= $field['content'];
                }
            }
            $form .= $this->form_end();
            return $form;
        }


        private function sort_settings(array $settings = []): array
        {
            foreach ($settings as $key => $value) {
                if ($value['type'] === 'checkbox' && isset($value['choices']) && !empty($value['choices'])) {
                    $choices = $value['choices'];
                    usort($choices, fn($a, $b) => $a['order'] <=> $b['order']);
                    $settings[$key]['choices'] = $choices;
                }
            }
            usort($settings, fn($a, $b) => $a['order'] <=> $b['order']);

            return $settings;
        }

        /**
         * This function responsible for create the start of tag form
         *
         * @param array $args [
         * class    => ''
         * id       => ''
         * ]
         */
        public function form_start(array $args = []): string
        {
            $defaults = [
                'attr'       => '',
                'class'      => '',
                'form_class' => '',
                'id'         => ''
            ];

            $input_data = array_merge($defaults, $args);

            $classes = explode(' ', $input_data['class']);
            if (!empty($classes)) {
                $classes[0] = $classes[0] . '-container';
            }
            $classes = implode(' ', $classes);

            ob_start();
            ?>
            <div class="<?= B2b::_DOMAIN_NAME ?>_form_container <?= $classes ?>">
            <form action="" class="<?= B2b::_DOMAIN_NAME ?>_form <?= $input_data['class'] ?> <?= $input_data['form_class'] ?>" id="<?= $input_data['id'] ?>" <?= $input_data['attr'] ?>>
            <?php
            return ob_get_clean();
        }

        /**
         * This function responsible for create stander input field
         *
         * @param array $args [
         * type          => (text / email / password / number)
         * label         => ''
         * name          => ''
         * required      => ''
         * placeholder   => ''
         * class         => ''
         * id            => default is B2b::_DOMAIN_NAME_name
         * value         => ''
         * default_value => ''
         * visibility    => ''
         * before        => ''
         * after         => ''
         * autocomplete  => default on
         * hint          => ''
         * abbr          => ''
         * order         => 0
         * extra_attr    => [
         *   'maxlength' => '50',
         *   'minlength' => '',
         *   'max'       => '',
         *   'min'       => '',
         *   ]
         * ]
         *
         * @return string
         *
         */
        public function std_inputs(array $args = []): string
        {
            ob_start();
            $defaults = [
                'type'           => 'text',
                'label'          => '',
                'name'           => '',
                'required'       => FALSE,
                'placeholder'    => '',
                'class'          => '',
                'id'             => (empty($args['name'])) ? "" : B2b::_DOMAIN_NAME . '_' . $args['name'],
                'value'          => '',
                'default_value'  => '',
                'visibility'     => '',
                'before'         => '',
                'after'          => '',
                'before_wrapper' => '',
                'after_wrapper'  => '',
                'autocomplete'   => 'on',
                'hint'           => '',
                'abbr'           => __("This field is required", "b2b"),
                'order'          => 0,
                'inline'         => FALSE,
                'extra_attr'     => [
                    'maxlength' => '255',
                    'minlength' => '',
                    'max'       => '',
                    'min'       => '',
                    'step'      => 1
                ]
            ];

            $input_data = array_merge($defaults, $args);
            $value      = (empty($input_data['default_value']) && $input_data['default_value'] !== 0) ? $input_data['value'] : $input_data['default_value'];

            ?>

            <?= $input_data['before_wrapper'] ?>
            <div class="form-group <?= B2b::_DOMAIN_NAME ?>-input-wrapper <?= boolval($input_data['inline']) ? 'row' : '' ?> <?= $input_data['class'] ?>">
                <?= $input_data['before'] ?>
                <?= boolval($input_data['inline']) ? '<div class="col-sm-2 ">' : '' ?>
                <label for="<?= $input_data['id'] ?>" class="<?= B2b::_DOMAIN_NAME ?>-label"><?= $input_data['label'] ?></label>
                <?= boolval($input_data['inline']) ? '</div>' : '' ?>

                <?= boolval($input_data['inline']) ? '<div class="col-sm-10 ">' : '' ?>
                <input type="<?= $input_data['type'] ?>"
                       class="form-control <?= B2b::_DOMAIN_NAME ?>-input"
                       id="<?= $input_data['id'] ?>"
                       name="<?= $input_data['name'] ?>"
                       value="<?= $value ?>"
                       autocomplete="<?= $input_data['autocomplete'] ?>"
                       placeholder="<?= $input_data['placeholder'] ?>"
                       aria-describedby="<?= $input_data['id'] . "_help" ?>"
                    <?= $this->create_attr($input_data) ?>
                    <?= $input_data['visibility'] ?>
                    <?= $this->create_attr($input_data['extra_attr']) ?>
                    <?= $input_data['required'] ? 'required="required"' : '' ?> <?= $input_data['type'] == 'number' && isset($input_data['step']) ? 'step="' . $input_data['step'] . '"' : '' ?>>
                <?php
                    if (!empty($input_data['hint'])) {
                        ?>
                        <small id="<?= $input_data['id'] . "_help" ?>" class="form-text text-muted"><?= $input_data['hint'] ?></small><?php
                    }
                ?>
                <?= boolval($input_data['inline']) ? '</div>' : '' ?>
                <?= $input_data['after'] ?>
            </div>
            <?= $input_data['after_wrapper'] ?>

            <?php

            return ob_get_clean();
        }

        /**
         * This function responsible for create extra html attributes.
         *
         * @param array $args
         *
         * @return string
         */
        public function create_attr(array $args = []): string
        {
            $attrs = '';
            if (isset($args['extra_attr']) && is_array($args['extra_attr']) && !empty($args['extra_attr'])) {
                foreach ($args['extra_attr'] as $name => $value) {

                    if (isset($args['type'])) {
                        if ($args['type'] === 'number') {
                            if ($name === 'maxlength' || $name === 'minlength') {
                                continue;
                            }
                        } else {
                            if ($name == 'max' || $name == 'min' || $name == 'step') {
                                continue;
                            }
                        }

                        //                        if ($args['type'] === 'number' && $name === 'maxlength' || $name === 'minlength') {
                        //                            continue;
                        //                        }
                        //                        if ($args['type'] === 'number' && $name !== 'max' || $name !== 'min') {
                        //                            continue;
                        //                        }
                    }
                    if ($value) {
                        $attrs .= " $name='$value' ";
                    }
                }
            }

            return $attrs;
        }

        /**
         * This function responsible for creating the input field
         *
         * @param array $args
         *
         * @return string
         */
        public function create_hidden_inputs(array $args = []): string
        {
            ob_start();
            $defaults = [
                'id'         => '',
                'name'       => '',
                'value'      => '',
                'order'      => 0,
                'extra_attr' => []
            ];

            $input_data = array_merge($defaults, $args);

            ob_start();
            ?>
            <input type='hidden' id="<?= $input_data['id'] ?>" name="<?= $input_data['name'] ?>" value='<?= $input_data['value'] ?>'/>
            <?php
            return ob_get_clean();
        }

        /**
         * This function responsible for create file input field
         *
         * @param array $args [
         * label        => ''
         * name         => ''
         * required     => ''
         * class        => ''
         * id           => default is B2b::_DOMAIN_NAME_name
         * before       => ''
         * after        => ''
         * hint         => ''
         * accept       => ''
         * multiple     => ''
         * abbr          => ''
         * order         => 0
         * extra_attr   => []
         * ]
         *
         * @return string
         */
        public function file_inputs(array $args = []): string
        {
            ob_start();
            $defaults = [
                'label'          => '',
                'name'           => '',
                'value'          => '',
                'required'       => '',
                'class'          => '',
                'id'             => (empty($args['name'])) ? "" : B2b::_DOMAIN_NAME . '_' . $args['name'],
                'before'         => '',
                'after'          => '',
                'hint'           => '',
                'accept'         => '',
                'multiple'       => '',
                'before_wrapper' => '',
                'after_wrapper'  => '',
                'inline'         => FALSE,
                'abbr'           => __("This field is required", "b2b"),
                'order'          => 0,
                'thumbnail'      => '',
                'thumbnail_name' => __("No file selected", "b2b"),
                'extra_attr'     => []
            ];

            $input_data = array_merge($defaults, $args);
            echo $input_data['before_wrapper'];
            ?>
            <div class="input-group <?= B2b::_DOMAIN_NAME ?>-input-wrapper <?= boolval($input_data['inline']) ? 'row' : '' ?> <?= $input_data['class'] ?>">
                <?= $input_data['before'] ?>
                <?= boolval($input_data['inline']) ? '<div class="col-sm-2 ">' : '' ?>
                <label class="<?= B2b::_DOMAIN_NAME ?>-label" for="customFile"><?= $input_data['label'] ?></label>
                <?= boolval($input_data['inline']) ? '</div>' : '' ?>

                <?= boolval($input_data['inline']) ? '<div class="col-sm-10 ">' : '' ?>
                <input type="file"
                       class="form-control <?= B2b::_DOMAIN_NAME ?>-input <?= B2b::_DOMAIN_NAME ?>-attachment-uploader"
                       id="<?= $input_data['id'] ?>"
                       name="<?= $input_data['name'] ?>"
                       aria-describedby="<?= $input_data['id'] . "_help" ?>"
                       aria-label="Upload"
                       accept="<?= $input_data['accept'] ?>"
                    <?= $this->create_attr($input_data) ?>
                    <?= $input_data['multiple'] ?>
                    <?= $input_data['required'] ? 'required="required"' : '' ?>>
                <label class="input-group-text buttonLow buttonLow-id" for="<?= $input_data['id'] ?>"><?= __('Upload your University ID', 'b2b') ?></label>
                <?php
                    if (!empty($input_data['hint'])) {
                        ?>
                        <small id="<?= $input_data['id'] . "_help" ?>" class="form-text text-muted"><?= $input_data['hint'] ?></small><?php
                    }
                ?>
                <?= boolval($input_data['inline']) ? '</div>' : '' ?>
                <?= $input_data['after'] ?>
            </div>
            <?= $input_data['after_wrapper'] ?>
            <?php

            return ob_get_clean();
        }

        /**
         * This function responsible for create checkbox input field
         *
         * @param array $args [
         * type'    => 'checkbox',
         * choices' => array(
         *  array(
         *      label'      => ''
         *      name'       => ''
         *      required'   => ''
         *      class'      => ''
         *      id'         => default is B2b::_DOMAIN_NAME_name
         *      value'      => ''
         *      before'     => ''
         *      after'      => ''
         *      checked'    => ''
         *      abbr          => ''
         *      order         => 0
         *      extra_attr' => []
         *  )
         * )
         * order         => 0
         * ]
         *
         * @return string
         */
        public function checkbox_inputs(array $args = []): string
        {
            ob_start();
            $defaults   = [
                'type'    => 'checkbox',
                'class'   => '',
                'choices' => [
                    [
                        'label'      => '',
                        'name'       => '',
                        'required'   => '',
                        'class'      => '',
                        'id'         => '',
                        'value'      => '',
                        'before'     => '',
                        'after'      => '',
                        'checked'    => '',
                        'abbr'       => __("This field is required", "b2b"),
                        'order'      => 0,
                        'extra_attr' => []
                    ]
                ],
                'before'  => '',
                'after'   => '',
                'order'   => 0,
            ];
            $input_data = array_merge($defaults, $args);
            foreach ($input_data['choices'] as $k => $arr) {
                $input_data['choices'][$k] = array_merge($defaults['choices'][0], $arr);
            }

            ?><div class="form-group <?= B2b::_DOMAIN_NAME ?>-input-wrapper <?= $input_data['class'] ?>"><?php
            echo $input_data['before'];

            $count = 0;
            foreach ($input_data['choices'] as $name) {
                if (empty($name['id'])) {
                    $id = (empty($name['name'])) ? "" : B2b::_DOMAIN_NAME . '_' . str_replace('[]', '', $name['name']) . '_' . $count;
                    $count++;
                } else {
                    $id = $name['id'];
                }
                ?>
                <div class="form-check <?= B2b::_DOMAIN_NAME ?>-input-wrapper <?= $name['class'] ?>">
                    <?= $name['before'] ?>
                    <input type="<?= $input_data['type'] ?>"
                           class="<?= B2b::_DOMAIN_NAME ?>-checkbox"
                           id="<?= $id ?>"
                           name="<?= $name['name'] ?>"
                           value="<?= $name['value'] ?>" <?= $name['required'] ? 'required="required"' : '' ?> <?= $this->create_attr($name['extra_attr']) ?> <?= $name['checked'] ?>>
                    <label for="<?= $id ?>" class="<?= B2b::_DOMAIN_NAME ?>-label"><?= $name['label'] ?></label>
                    <?= $name['after'] ?>
                </div>
                <?php
            }

            echo $input_data['after'];
            ?></div><?php
            return ob_get_clean();
        }

        /**
         * This function responsible for create radio input field
         *
         * @param array $args [
         * type'    => 'checkbox',
         * name'    => ''
         * choices' => array(
         *  array(
         *      label'      => ''
         *      required'   => ''
         *      class'      => ''
         *      id'         => default is B2b::_DOMAIN_NAME_name
         *      value'      => ''
         *      before'     => ''
         *      after'      => ''
         *      checked'    => ''
         *      abbr          => ''
         *      order         => 0
         *      extra_attr' => []
         *  )
         * )
         * order         => 0
         * ]
         *
         * @return string
         */
        public function radio_inputs(array $args = []): string
        {
            ob_start();
            $defaults = [
                'type'     => 'radio',
                'title'    => '',
                'class'    => '',
                'name'     => '',
                'before'   => '',
                'after'    => '',
                'required' => TRUE,
                'abbr'     => __("This field is required", "b2b"),
                'choices'  => [
                    [
                        'label'      => '',
                        'class'      => '',
                        'id'         => (empty($args['choices']['name'])) ? "" : B2b::_DOMAIN_NAME . '_' . $args['choices']['name'],
                        'value'      => '',
                        'before'     => '',
                        'after'      => '',
                        'checked'    => '',
                        'order'      => 0,
                        'extra_attr' => []
                    ]
                ],
                'order'    => 0,
            ];

            $input_data = array_merge($defaults, $args);

            echo $input_data['before'];

            ?>
            <div class="<?= $input_data['class'] ?>"><?php
            ?><label> <?= $input_data['title'] ?></label><?php

            $count = 0;
            foreach ($input_data['choices'] as $name) {
                if (empty($name['id'])) {
                    $id = (empty($name['name'])) ? "" : B2b::_DOMAIN_NAME . '_' . str_replace('[]', '', $name['name']) . $count;
                    $count++;
                } else {
                    $id = $name['id'];
                }
                ?>
                <div class="form-check <?= B2b::_DOMAIN_NAME ?>-input-wrapper <?= $name['class'] ?>">
                    <?= $name['before'] ?>
                    <input type="<?= $input_data['type'] ?>"
                           class="<?= B2b::_DOMAIN_NAME ?>-radio"
                           id="<?= $id ?>"
                           name="<?= $input_data['name'] ?>"
                           value="<?= $name['value'] ?>" <?= $input_data['required'] ? 'required="required"' : '' ?> <?= $this->create_attr($name['extra_attr']) ?> <?= $name['checked'] ? 'checked' : '' ?>>
                    <label for="<?= $id ?>" class="<?= B2b::_DOMAIN_NAME ?>-label"><?= $name['label'] ?></label>
                    <?= $name['after'] ?>
                </div>
                <?php
            }

            ?></div><?php

            echo $input_data['after'];

            return ob_get_clean();
        }

        /**
         * This function responsible for create radio input field
         *
         * @param array $args [
         * type'       => 'switch',
         * label'      => ''
         * name'       => ''
         * required'   => ''
         * class'      => ''
         * id'         => default is B2b::_DOMAIN_NAME_name
         * before'     => ''
         * after'      => ''
         * checked'    => ''
         * abbr          => ''
         * order         => 0
         * extra_attr' => []
         * ]
         *
         * @return string
         */
        public function switch_inputs(array $args = []): string
        {
            ob_start();
            $defaults   = [
                'type'       => 'switch',
                'label'      => '',
                'name'       => '',
                'required'   => '',
                'class'      => '',
                'id'         => (empty($args['name'])) ? "" : B2b::_DOMAIN_NAME . '_' . $args['name'],
                'before'     => '',
                'after'      => '',
                'checked'    => '',
                'abbr'       => __("This field is required", "b2b"),
                'order'      => 0,
                'extra_attr' => []
            ];
            $input_data = array_merge($defaults, $args);

            ?>

            <div class="custom-control custom-switch <?= B2b::_DOMAIN_NAME ?>-input-wrapper <?= $input_data['class'] ?>">
                <?= $input_data['before'] ?>
                <input type="checkbox"
                       class="custom-control-input <?= B2b::_DOMAIN_NAME ?>-input <?= B2b::_DOMAIN_NAME ?>-switch <?= B2b::_DOMAIN_NAME . '-' . $input_data['class'] ?>"
                       id="<?= $input_data['id'] ?>"
                       name="<?= $input_data['name'] ?>"
                    <?= $input_data['required'] ? 'required="required"' : '' ?> <?= $this->create_attr($input_data) ?> <?= $input_data['checked'] ?>>
                <label class="custom-control-label" for="<?= $input_data['id'] ?>"><?= $input_data['label'] ?></label>
                <?= $input_data['after'] ?>
            </div>
            <?php
            return ob_get_clean();
        }

        /**
         * This function responsible for create the textare field
         *
         * @param array $args [
         * label         => ''
         * name          => ''
         * required      => ''
         * placeholder   => ''
         * class         => ''
         * id            => default is B2b::_DOMAIN_NAME_name
         * value         => ''
         * before        => ''
         * after         => ''
         * autocomplete  => default on
         * rows          => '3'
         * hint          => ''
         * abbr          => ''
         * order         => 0
         * extra_attr    => []
         * ]
         *
         * @return string
         *
         */
        public function textarea_inputs(array $args = []): string
        {
            ob_start();
            $defaults   = [
                'label'        => '',
                'name'         => '',
                'required'     => '',
                'placeholder'  => '',
                'class'        => '',
                'id'           => (empty($args['name'])) ? "" : B2b::_DOMAIN_NAME . '_' . $args['name'],
                'value'        => '',
                'before'       => '',
                'after'        => '',
                'inline'       => FALSE,
                'autocomplete' => 'on',
                'rows'         => '3',
                'hint'         => '',
                'abbr'         => __("This field is required", "b2b"),
                'order'        => 0,
                'extra_attr'   => []
            ];
            $input_data = array_merge($defaults, $args);
            ?>
            <div class="form-group <?= B2b::_DOMAIN_NAME ?>-input-wrapper <?= boolval($input_data['inline']) ? 'row' : '' ?> <?= $input_data['class'] ?>">
                <?= $input_data['before'] ?>
                <?= boolval($input_data['inline']) ? '<div class="col-sm-2 ">' : '' ?>
                <label for="<?= $input_data['id'] ?>" class="<?= B2b::_DOMAIN_NAME ?>-label"><?= $input_data['label'] ?></label>
                <?= boolval($input_data['inline']) ? '</div>' : '' ?>

                <?= boolval($input_data['inline']) ? '<div class="col-sm-10 ">' : '' ?>
                <textarea class="form-control <?= B2b::_DOMAIN_NAME ?>-textarea"
                          id="<?= $input_data['id'] ?>"
                          name="<?= $input_data['name'] ?>"
                          placeholder="<?= $input_data['placeholder'] ?>"
                          autocomplete="<?= $input_data['autocomplete'] ?>"
                          rows="<?= $input_data['rows'] ?>"
                          <?= $input_data['required'] ? 'required="required"' : '' ?>
                    <?= $this->create_attr($input_data['extra_attr']) ?>><?= $input_data['value'] ?></textarea>
                <?php
                    if (!empty($input_data['hint'])) {
                        ?>
                        <small id="<?= $input_data['id'] . "_help" ?>" class="form-text text-muted"><?= $input_data['hint'] ?></small><?php
                    }
                ?>
                <?= boolval($input_data['inline']) ? '</div>' : '' ?>
                <?= $input_data['after'] ?>
            </div>
            <?php
            return ob_get_clean();
        }

        /**
         * This function responsible for create selectBox input field
         *
         * @param array $args [
         * label          => ''
         * name           => ''
         * required       => ''
         * placeholder    => ''
         * options        => [option_value => option_title]
         * default_option => ''
         * select_option  => ''
         * class          => ''
         * id             => default is B2b::_DOMAIN_NAME_name
         * before         => ''
         * after          => ''
         * multiple       => ''
         * abbr          => ''
         * order         => 0
         * extra_attr     => []
         *
         * @return string
         *
         */
        public function selectBox_inputs(array $args = []): string
        {
            ob_start();
            $defaults   = [
                'label'          => '',
                'name'           => '',
                'required'       => '',
                'placeholder'    => '',
                'options'        => [],
                'default_option' => '',
                'select_option'  => '',
                'class'          => '',
                'id'             => (empty($args['name'])) ? "" : B2b::_DOMAIN_NAME . '_' . $args['name'],
                'before'         => '',
                'after'          => '',
                'multiple'       => '',
                'inline'         => FALSE,
                'abbr'           => __("This field is required", "b2b"),
                'order'          => 0,
                'extra_attr'     => []
            ];
            $input_data = array_merge($defaults, $args);

            ?>
            <div class="form-group <?= B2b::_DOMAIN_NAME ?>-input-wrapper <?= boolval($input_data['inline']) ? 'row' : '' ?> <?= $input_data['class'] ?>">
                <?= $input_data['before'] ?>
                <?= boolval($input_data['inline']) ? '<div class="col-sm-2 ">' : '' ?>
                <label for="<?= $input_data['id'] ?>" class="<?= B2b::_DOMAIN_NAME ?>-label"><?= $input_data['label'] ?></label>

                <?= boolval($input_data['inline']) ? '</div>' : '' ?>

                <?= boolval($input_data['inline']) ? '<div class="col-sm-10 ">' : '' ?>
                <select class="form-control <?= B2b::_DOMAIN_NAME ?>-input" id="<?= $input_data['id'] ?>"
                        name="<?= $input_data['name'] ?>" <?= $this->create_attr($input_data) ?> <?= $input_data['required'] ? 'required="required"' : '' ?>>
                    <?php
                        if (empty($input_data['default_option']) && empty($input_data['select_option'])) {
                            ?>
                            <option value="" disabled="disabled" selected><?= $input_data['placeholder'] ?></option> <?php
                        }
                        foreach ($input_data['options'] as $value => $title) {
                            ?>
                            <option
                            value="<?= $value ?>" <?= (!empty($input_data['default_option']) && $input_data['default_option'] === $value) ? 'selected' : '' ?>><?= $title ?></option><?php
                        }
                    ?>
                </select>
                <?= boolval($input_data['inline']) ? '</div>' : '' ?>

                <?= $input_data['after'] ?>
            </div>
            <?php
            return ob_get_clean();
        }

        /**
         * This function responsible for creating the wp nonce
         *
         * @param array $args
         *
         * @return string
         */
        public function create_nonce(array $args): string
        {
            $defaults = [
                'type'  => 'nonce',
                'name'  => '',
                'value' => '',
                'order' => 0
            ];

            $nonce_data = array_merge($defaults, $args);

            return wp_nonce_field($nonce_data['value'], $nonce_data['name'], true, false);
        }

        /**
         * This function responsible for create the form submit button
         *
         * @param array $args [
         * value    => ''
         * class    => ''
         * id       => ''
         * before   => ''
         * after    => ''
         * ]
         *
         */
        public function form_submit_button(array $args = []): string
        {
            $defaults = [
                'type'   => 'submit',
                'value'  => 'Submit',
                'class'  => '',
                'id'     => '',
                'before' => '',
                'after'  => '',
                'recaptcha_form_name' => '',
                'order'  => 0
            ];

            $input_data = array_merge($defaults, $args);

            ob_start();

            if (is_plugin_active('google-captcha/google-captcha.php') && function_exists('gglcptch_display_custom') && !empty($input_data['recaptcha_form_name'])) {
                echo apply_filters('gglcptch_display_recaptcha', '', $input_data['recaptcha_form_name']);
            }

            ?>
            <div class="form-group">
                <?= $input_data['before'] ?>
                <button class="btn <?= B2b::_DOMAIN_NAME ?>-btn <?= $input_data['class'] ?>" id="<?= $input_data['id'] ?>"
                        type="<?= $input_data['type'] ?>"><?= $input_data['value'] ?></button>
                <?= $input_data['after'] ?>
            </div>
            <?php
            return ob_get_clean();
        }

        /**
         * This functions responsible for sort inputs
         *
         * @param array $settings
         *
         * @return array
         */
        /*private function sort_settings(array $settings = []): array
        {
            foreach ($settings as $key => $value) {
                if ($value['type'] === 'checkbox' && isset($value['choices']) && !empty($value['choices'])) {
                    $choices = $value['choices'];
                    usort($choices, function($a, $b) {
                        return $a['order'] > $b['order'];
                    });
                    $settings[$key]['choices'] = $choices;
                }
            }
            usort($settings, function($a, $b) {
                return $a['order'] > $b['order'];
            });

            return $settings;
        }*/
        /**
         * This function responsible for create the end tag of form
         *
         * @version 1.0
         * @since 1.0.0
         * @package b2b
         * @author Mustafa Shaaban
         * @return false|string
         */
        public function form_end(): string
        {
            ob_start();
            ?>
            </form>
            </div>
            <?php
            return ob_get_clean();
        }
    }
