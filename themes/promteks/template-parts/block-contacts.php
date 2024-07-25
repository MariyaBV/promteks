<?php
$options = get_fields('options');
?>
    <section class="contacts">
        <h1>Контакты</h1>
        <div class="contact-info">
        <div class="info">
            <div class="contact">
                <div class="contact-labels">
                <p>Фактический адрес:</p>
                <p>Телефон:</p>
                <p>E-mail:</p>
                <p>Время работы:</p>
            </div>
            <div class="contact-values">
                <p><?= $options['actual-address']; ?></p>
                <p><?= $options['phone']; ?></p>
                <p><?= $options['email']; ?></p>
                <p><?= $options['operating_mode']['Mon-Fri']; ?> </br> <?= $options['operating_mode']['Sat']; ?></p>
             </div>
             </div>
            <div class="social-icons">
            <?php foreach ((array)$r['social-network'] as $item): ?>
               <img src="<?php echo $item['img']; ?>" alt="Social Icon"  />
            <?php endforeach; ?>
            </div>
        </div>
        <div class="map">
            <img src="<?= $options['карта-картинка']; ?>" alt="Карта">
        </div>

    </div>
        <h2>Как до нас добраться</h2>
        <div class="direction">
            <img src="https://s3-alpha-sig.figma.com/img/8dce/6884/9545f09c96bab80235c63e64519f2368?Expires=1722816000&Key-Pair-Id=APKAQ4GOSFWCVNEHN3O4&Signature=bfCz0iAQpnV~BpV89X37BbzTKsGoonP3~qR7b7xZpTN6inW40LK8pEd~lHanEatCmPMepEu4-yPE6tjVxe7~Ju4B0C8G0GohZDtl7FUQgee3-JMgCa7H3n3M0XYqiRHNpxc-dooKM25k-l~k6UcD3r~YTdj17VrdcnFry-n8kusKa3oM6kf580VQWwtvEvJpoUVsDRdooRFRQcIlqDmowE8fd6ykxnFfA0YTgbZ6Ddpb~XZObD8XHiz3~VHpEV6lr7cy46tlfDSXhokNh4W9E0n84Ryi4xxnSlUtOVdAQ1dpBZgI4na~jLvsP1Ggu6C27epKBSwyRnQ7Y0jkF-BH2A__"  alt="Маршрут">
        </div>

        <div class="steps">
            <div class="step">
                <?php foreach ($r['steps_how_to_get_there'] as $item): ?>
                <h3><?php echo $item['text']; ?></h3>
                <img src="<?php echo $item['img']; ?>" alt="Шаги"  />
                <?php endforeach; ?>
                 </div>

        </div>
    </section>