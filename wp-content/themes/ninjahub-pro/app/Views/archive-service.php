<?php
    /**
     * @Filename: archive-service.php
     * @Description:
     * @User: NINJA MASTER - Mustafa Shaaban
     * @Date: 4/26/2023
     */

    use NH\APP\HELPERS\Nh_Hooks;
    use NH\APP\MODELS\FRONT\MODULES\Nh_Service;
    use NH\Nh;

    get_header();

    Nh_Hooks::enqueue_style(Nh::_DOMAIN_NAME . '-public-style-home-landing', Nh_Hooks::PATHS['public']['css'] . '/pages/landing/home');
    Nh_Hooks::enqueue_style(Nh::_DOMAIN_NAME . '-public-style-services-landing', Nh_Hooks::PATHS['public']['css'] . '/pages/landing/services');

    $service_obj = new Nh_Service();
    $category = $service_obj->get_taxonomy_terms('service-category');
?>


    <section class="page-content">
        <!-- Services Content -->
        <div class="services-content">
            <!-- Services Categories -->
            <div class="services-categories">
                <h1 class="b2b-title"><?= __('B2B Services', 'ninja') ?></h1>
                <h2 class="services-title"><?= __('Services', 'ninja') ?></h2>
                <p class="services-description"><?= __('Services of the specialized administrative and technical consulting sector', 'ninja') ?></p>
                <ul class="nav nav-tabs services-categories-navigation">
                    <?php
                        foreach ($category as $key => $term) {
                            ?>
                            <li class="nav-item service-category-link">
                                <button type="button" class="nav-link <?= $key === 0 ? 'active' : '' ?>" data-bs-toggle="tab" data-bs-target="#category-<?= $key ?>">
                                    <span class="category-number"><?= $key+1 ?>.</span>
                                    <span class="category-name"><?= $term->name ?></span>
                                </button>
                            </li>
                            <?php
                        }
                    ?>
                </ul>
            </div>

            <!-- Services Categories Content -->
            <div class="tab-content services-categories-content">
                <div id="category-1" class="services-category-content tab-pane fade show active">
                    <div class="services-group-wrapper">
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">01.</span>
                                <h3 class="service-title">Merge opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">1.1</span>
                                <h3 class="service-title">Seize opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                            <div class="service">
                                <span class="service-number">1.1</span>
                                <h3 class="service-title">Feasibility studies</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">01.</span>
                                <h3 class="service-title">Merge opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">1.1</span>
                                <h3 class="service-title">Seize opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                            <div class="service">
                                <span class="service-number">1.1</span>
                                <h3 class="service-title">Feasibility studies</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">01.</span>
                                <h3 class="service-title">Merge opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="category-2" class="services-category-content tab-pane fade">
                    <div class="services-group-wrapper">
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">01.</span>
                                <h3 class="service-title">Merge opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">1.1</span>
                                <h3 class="service-title">Seize opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                            <div class="service">
                                <span class="service-number">1.1</span>
                                <h3 class="service-title">Feasibility studies</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">01.</span>
                                <h3 class="service-title">Merge opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">1.1</span>
                                <h3 class="service-title">Seize opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                            <div class="service">
                                <span class="service-number">1.1</span>
                                <h3 class="service-title">Feasibility studies</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">01.</span>
                                <h3 class="service-title">Merge opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="category-3" class="services-category-content tab-pane fade">
                    <div class="services-group-wrapper">
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">01.</span>
                                <h3 class="service-title">Merge opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">1.1</span>
                                <h3 class="service-title">Seize opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                            <div class="service">
                                <span class="service-number">1.1</span>
                                <h3 class="service-title">Feasibility studies</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">01.</span>
                                <h3 class="service-title">Merge opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">1.1</span>
                                <h3 class="service-title">Seize opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                            <div class="service">
                                <span class="service-number">1.1</span>
                                <h3 class="service-title">Feasibility studies</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">01.</span>
                                <h3 class="service-title">Merge opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="category-4" class="services-category-content tab-pane fade">
                    <div class="services-group-wrapper">
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">01.</span>
                                <h3 class="service-title">Merge opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">1.1</span>
                                <h3 class="service-title">Seize opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                            <div class="service">
                                <span class="service-number">1.1</span>
                                <h3 class="service-title">Feasibility studies</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">01.</span>
                                <h3 class="service-title">Merge opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">1.1</span>
                                <h3 class="service-title">Seize opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                            <div class="service">
                                <span class="service-number">1.1</span>
                                <h3 class="service-title">Feasibility studies</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">01.</span>
                                <h3 class="service-title">Merge opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="category-5" class="services-category-content tab-pane fade">
                    <div class="services-group-wrapper">
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">01.</span>
                                <h3 class="service-title">Merge opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">1.1</span>
                                <h3 class="service-title">Seize opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                            <div class="service">
                                <span class="service-number">1.1</span>
                                <h3 class="service-title">Feasibility studies</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">01.</span>
                                <h3 class="service-title">Merge opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">1.1</span>
                                <h3 class="service-title">Seize opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                            <div class="service">
                                <span class="service-number">1.1</span>
                                <h3 class="service-title">Feasibility studies</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">01.</span>
                                <h3 class="service-title">Merge opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="category-6" class="services-category-content tab-pane fade">
                    <div class="services-group-wrapper">
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">01.</span>
                                <h3 class="service-title">Merge opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">1.1</span>
                                <h3 class="service-title">Seize opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                            <div class="service">
                                <span class="service-number">1.1</span>
                                <h3 class="service-title">Feasibility studies</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">01.</span>
                                <h3 class="service-title">Merge opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">1.1</span>
                                <h3 class="service-title">Seize opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                            <div class="service">
                                <span class="service-number">1.1</span>
                                <h3 class="service-title">Feasibility studies</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">01.</span>
                                <h3 class="service-title">Merge opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="category-7" class="services-category-content tab-pane fade">
                    <div class="services-group-wrapper">
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">01.</span>
                                <h3 class="service-title">Merge opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">1.1</span>
                                <h3 class="service-title">Seize opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                            <div class="service">
                                <span class="service-number">1.1</span>
                                <h3 class="service-title">Feasibility studies</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">01.</span>
                                <h3 class="service-title">Merge opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">1.1</span>
                                <h3 class="service-title">Seize opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                            <div class="service">
                                <span class="service-number">1.1</span>
                                <h3 class="service-title">Feasibility studies</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">01.</span>
                                <h3 class="service-title">Merge opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="category-8" class="services-category-content tab-pane fade">
                    <div class="services-group-wrapper">
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">01.</span>
                                <h3 class="service-title">Merge opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">1.1</span>
                                <h3 class="service-title">Seize opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                            <div class="service">
                                <span class="service-number">1.1</span>
                                <h3 class="service-title">Feasibility studies</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">01.</span>
                                <h3 class="service-title">Merge opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">1.1</span>
                                <h3 class="service-title">Seize opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                            <div class="service">
                                <span class="service-number">1.1</span>
                                <h3 class="service-title">Feasibility studies</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">01.</span>
                                <h3 class="service-title">Merge opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="category-9" class="services-category-content tab-pane fade">
                    <div class="services-group-wrapper">
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">01.</span>
                                <h3 class="service-title">Merge opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">1.1</span>
                                <h3 class="service-title">Seize opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                            <div class="service">
                                <span class="service-number">1.1</span>
                                <h3 class="service-title">Feasibility studies</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">01.</span>
                                <h3 class="service-title">Merge opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">1.1</span>
                                <h3 class="service-title">Seize opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                            <div class="service">
                                <span class="service-number">1.1</span>
                                <h3 class="service-title">Feasibility studies</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                        <div class="services-group">
                            <div class="service">
                                <span class="service-number">01.</span>
                                <h3 class="service-title">Merge opportunities</h3>
                                <p class="service-description">
                                    Long established fact that a reader will be distracted by the <span class="highlighted">readable</span>
                                    content fact that a reader will be.
                                </p>
                                <a href="./service_en.html" class="service-link">
                                    Read more
                                    <span class="service-link-icons">
									<i class="icon bbc-right"></i><i class="icon bbc-right"></i>
								</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div> <!-- </layout> -->
    </main>
    </div> <!-- </landing-page> -->


    <script>
        // Script reference:
        // https://alvarotrigo.com/blog/scroll-horizontally-with-mouse-wheel-vanilla-java/
        const scrollContainer = document.querySelector('.services-categories-content');

        scrollContainer.addEventListener('wheel', (evt) => {
            evt.preventDefault();
            scrollContainer.scrollLeft += evt.deltaY;
        });
    </script>
<?php get_footer();
