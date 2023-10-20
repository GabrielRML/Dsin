<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$this->title;?></title>

    <!-- Favicon -->
    <!-- <link rel="icon" type="image/x-icon" href="<?= URL ?>public/assets/favicon.ico"> -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />

    <!-- BOX ICONS -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css"> -->

    <link rel="stylesheet" href="<?= URL ?>public/css/main.css">

    <!-- Chamando Font Awesome -->
    <link rel="stylesheet" href="<?= URL ?>public/fontawesome/css/all.min.css">

    <!-- Instância do bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="<?=URL;?>public/MDB/css/mdb.min.css" />
    <script src="<?=URL;?>public/MDB/js/mdb.min.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/vue-multiselect@2.1.6/dist/vue-multiselect.min.css">
    <script src="https://unpkg.com/vue-multiselect@2.1.6"></script>

    <link rel="stylesheet" href="<?=URL;?>public/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap"/>

    <!-- VUE -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2.7.14/dist/vue.min.js" type="text/javascript"></script>
    

    <!-- Axios -->
    <script src="<?=URL;?>public/js/axios.min.js"></script>

    <script src="<?=URL;?>public/js/common.js"></script>

    <?php
        if (isset($this->css)) {
            foreach ($this->css as $c) {
                echo ("<link href=\"" . URL . "$c\" rel=\"stylesheet\" type=\"text/css\">\n");
            }
        }
    ?>
  
    <?php
        if (isset($this->js)) {
            foreach ($this->js as $j) {
                echo ("<script src='" . URL . "$j' type='text/javascript'></script>\n");
            }
        }
    ?>
</head>

<body>

    <div id="mainLayout"></div>

    <script>
        Vue.component('vue-multiselect', window.VueMultiselect.default);
        const mainLayout = new Vue({
            el: '#mainLayout',
            template: `
              <div>
                  <AppVue ref='AppVue'></AppVue>
              </div>
            `,
            data: function() {
                return {}
            },
            methods: {}
        });
    </script>
