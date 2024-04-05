(function ($) {
  'use strict'
  function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1)
  }

  function createSkinBlock(colors, callback, noneSelected) {
    var $block = $('<select />', {
      class: noneSelected ? 'custom-select mb-3 border-0' : 'custom-select mb-3 text-light border-0 ' + colors[0].replace(/accent-|navbar-/, 'bg-')
    })

    if (noneSelected) {
      var $default = $('<option />', {
        text: 'None Selected'
      })
      if (callback) {
        $default.on('click', callback)
      }

      $block.append($default)
    }

    colors.forEach(function (color) {
      var $color = $('<option />', {
        class: (typeof color === 'object' ? color.join(' ') : color).replace('navbar-', 'bg-').replace('accent-', 'bg-'),
        text: capitalizeFirstLetter((typeof color === 'object' ? color.join(' ') : color).replace(/navbar-|accent-|bg-/, '').replace('-', ' '))
      })

      $block.append($color)

      $color.data('color', color)

      if (callback) {
        $color.on('click', callback)
      }
    })

    return $block
  }

  var $sidebar = $('.control-sidebar')
  var $container = $('<div />', {
    class: 'p-3 control-sidebar-content'
  })

  $sidebar.append($container)
  // Checkboxes - customizar - menu direita
  $container.append(
    '<br><h5>Customizar</h5><hr class="mb-2"/>'
  )


  //dark-mode------------------------------>
  var $dark_mode_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('body').hasClass('dark-mode'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      //$('body').addClass('dark-mode')
      location.href = 'https://' + window.location.hostname + '/assets/customizar/gravar_customizacao.php?customizar=dark_mode&old_url=' + window.location.href;
    } else {
      //$('body').removeClass('dark-mode')
      location.href = 'https://' + window.location.hostname + '/assets/customizar/gravar_customizacao.php?customizar=dark_mode&old_url=' + window.location.href;
    }
  })
  var $dark_mode_container = $('<div />', { class: 'mb-4' }).append($dark_mode_checkbox).append('<span>Dark Mode</span>')
  $container.append($dark_mode_container)





  $container.append('<h6>Opções do cabeçalho</h6>')


  //fixar cabeçalho
  var $header_fixed_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('body').hasClass('layout-navbar-fixed'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      //$('body').addClass('layout-navbar-fixed')
      location.href = 'https://' + window.location.hostname + '/assets/customizar/gravar_customizacao.php?customizar=fixar_cabecalho&old_url=' + window.location.href;
    } else {
      //$('body').removeClass('layout-navbar-fixed')
      location.href = 'https://' + window.location.hostname + '/assets/customizar/gravar_customizacao.php?customizar=fixar_cabecalho&old_url=' + window.location.href;
    }
  })
  var $header_fixed_container = $('<div />', { class: 'mb-1' }).append($header_fixed_checkbox).append('<span>Fixar</span>')
  $container.append($header_fixed_container)



  //Dropdown Legacy Offset
  var $dropdown_legacy_offset_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.main-header').hasClass('dropdown-legacy'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      //$('.main-header').addClass('dropdown-legacy')
      location.href = 'https://' + window.location.hostname + '/assets/customizar/gravar_customizacao.php?customizar=dropdown_legacy&old_url=' + window.location.href;
    } else {
      //$('.main-header').removeClass('dropdown-legacy')
      location.href = 'https://' + window.location.hostname + '/assets/customizar/gravar_customizacao.php?customizar=dropdown_legacy&old_url=' + window.location.href;
    }
  })
  var $dropdown_legacy_offset_container = $('<div />', { class: 'mb-1' }).append($dropdown_legacy_offset_checkbox).append('<span>Dropdown Legacy Offset</span>')
  $container.append($dropdown_legacy_offset_container)

  //sem bordas
  var $no_border_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.main-header').hasClass('border-bottom-0'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      //$('.main-header').addClass('border-bottom-0')
      location.href = 'https://' + window.location.hostname + '/assets/customizar/gravar_customizacao.php?customizar=sem_bordas&old_url=' + window.location.href;
    } else {
      //$('.main-header').removeClass('border-bottom-0')
      location.href = 'https://' + window.location.hostname + '/assets/customizar/gravar_customizacao.php?customizar=sem_bordas&old_url=' + window.location.href;
    }
  })
  var $no_border_container = $('<div />', { class: 'mb-4' }).append($no_border_checkbox).append('<span>Sem bordas</span>')
  $container.append($no_border_container)

  $container.append('<h6>Barra Lateral</h6>')

  //menu fechado
  var $sidebar_collapsed_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('body').hasClass('sidebar-collapse'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      //$('body').addClass('sidebar-collapse')
      //$(window).trigger('resize')
      location.href = 'https://' + window.location.hostname + '/assets/customizar/gravar_customizacao.php?customizar=menu_fechado&old_url=' + window.location.href;
    } else {
      //$('body').removeClass('sidebar-collapse')
      //$(window).trigger('resize')
      location.href = 'https://' + window.location.hostname + '/assets/customizar/gravar_customizacao.php?customizar=menu_fechado&old_url=' + window.location.href;
    }
  })
  var $sidebar_collapsed_container = $('<div />', { class: 'mb-1' }).append($sidebar_collapsed_checkbox).append('<span>Menu Fechado</span>')
  $container.append($sidebar_collapsed_container)


  $(document).on('collapsed.lte.pushmenu', '[data-widget="pushmenu"]', function () {
    $sidebar_collapsed_checkbox.prop('checked', true)
  })
  $(document).on('shown.lte.pushmenu', '[data-widget="pushmenu"]', function () {
    $sidebar_collapsed_checkbox.prop('checked', false)
  })


  //menu_flat
  var $flat_sidebar_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.nav-sidebar').hasClass('nav-flat'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      //$('.nav-sidebar').addClass('nav-flat')
      location.href = 'https://' + window.location.hostname + '/assets/customizar/gravar_customizacao.php?customizar=menu_flat&old_url=' + window.location.href;
    } else {
      //$('.nav-sidebar').removeClass('nav-flat')
      location.href = 'https://' + window.location.hostname + '/assets/customizar/gravar_customizacao.php?customizar=menu_flat&old_url=' + window.location.href;
    }
  })
  var $flat_sidebar_container = $('<div />', { class: 'mb-1' }).append($flat_sidebar_checkbox).append('<span>Menu Flat</span>')
  $container.append($flat_sidebar_container)


  //menu_legacy
  var $legacy_sidebar_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.nav-sidebar').hasClass('nav-legacy'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      //$('.nav-sidebar').addClass('nav-legacy')
      location.href = 'https://' + window.location.hostname + '/assets/customizar/gravar_customizacao.php?customizar=menu_legacy&old_url=' + window.location.href;
    } else {
      //$('.nav-sidebar').removeClass('nav-legacy')
      location.href = 'https://' + window.location.hostname + '/assets/customizar/gravar_customizacao.php?customizar=menu_legacy&old_url=' + window.location.href;
    }
  })
  var $legacy_sidebar_container = $('<div />', { class: 'mb-1' }).append($legacy_sidebar_checkbox).append('<span>Menu Legacy</span>')
  $container.append($legacy_sidebar_container)

  //menu compacto
  var $compact_sidebar_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.nav-sidebar').hasClass('nav-compact'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      //$('.nav-sidebar').addClass('nav-compact')
      location.href = 'https://' + window.location.hostname + '/assets/customizar/gravar_customizacao.php?customizar=menu_compact&old_url=' + window.location.href;
    } else {
      //$('.nav-sidebar').removeClass('nav-compact')
      location.href = 'https://' + window.location.hostname + '/assets/customizar/gravar_customizacao.php?customizar=menu_compact&old_url=' + window.location.href;
    }
  })
  var $compact_sidebar_container = $('<div />', { class: 'mb-1' }).append($compact_sidebar_checkbox).append('<span>Menu Compact</span>')
  $container.append($compact_sidebar_container)

  //submenu
  var $child_indent_sidebar_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.nav-sidebar').hasClass('nav-child-indent'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      //$('.nav-sidebar').addClass('nav-child-indent')
      location.href = 'https://' + window.location.hostname + '/assets/customizar/gravar_customizacao.php?customizar=submenu&old_url=' + window.location.href;
    } else {
      //$('.nav-sidebar').removeClass('nav-child-indent')
      location.href = 'https://' + window.location.hostname + '/assets/customizar/gravar_customizacao.php?customizar=submenu&old_url=' + window.location.href;
    }
  })
  var $child_indent_sidebar_container = $('<div />', { class: 'mb-1' }).append($child_indent_sidebar_checkbox).append('<span>Submenu Alinhamento</span>')
  $container.append($child_indent_sidebar_container)


  //submenu_esconder
  var $child_hide_sidebar_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.nav-sidebar').hasClass('nav-collapse-hide-child'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      //$('.nav-sidebar').addClass('nav-collapse-hide-child')
      location.href = 'https://' + window.location.hostname + '/assets/customizar/gravar_customizacao.php?customizar=submenu_esconder&old_url=' + window.location.href;
    } else {
      //$('.nav-sidebar').removeClass('nav-collapse-hide-child')
      location.href = 'https://' + window.location.hostname + '/assets/customizar/gravar_customizacao.php?customizar=submenu_esconder&old_url=' + window.location.href;
    }
  })
  var $child_hide_sidebar_container = $('<div />', { class: 'mb-1' }).append($child_hide_sidebar_checkbox).append('<span>Submenu Esconder/Fechar</span>')
  $container.append($child_hide_sidebar_container)

  //desabilitar_auto_expand
  var $no_expand_sidebar_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.main-sidebar').hasClass('sidebar-no-expand'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      //$('.main-sidebar').addClass('sidebar-no-expand')
      location.href = 'https://' + window.location.hostname + '/assets/customizar/gravar_customizacao.php?customizar=desabilitar_auto_expand&old_url=' + window.location.href;
    } else {
      //$('.main-sidebar').removeClass('sidebar-no-expand')
      location.href = 'https://' + window.location.hostname + '/assets/customizar/gravar_customizacao.php?customizar=desabilitar_auto_expand&old_url=' + window.location.href;
    }
  })
  var $no_expand_sidebar_container = $('<div />', { class: 'mb-4' }).append($no_expand_sidebar_checkbox).append('<span>Desabilitar Auto-Expand</span>')
  $container.append($no_expand_sidebar_container)



  //rodape
  $container.append('<h6>Rodapé</h6>')

  //fixa_rodape
  var $footer_fixed_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('body').hasClass('layout-footer-fixed'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      //$('body').addClass('layout-footer-fixed')
      location.href = 'https://' + window.location.hostname + '/assets/customizar/gravar_customizacao.php?customizar=fixa_rodape&old_url=' + window.location.href;
    } else {
      //$('body').removeClass('layout-footer-fixed')
      location.href = 'https://' + window.location.hostname + '/assets/customizar/gravar_customizacao.php?customizar=fixa_rodape&old_url=' + window.location.href;
    }
  })
  var $footer_fixed_container = $('<div />', { class: 'mb-4' }).append($footer_fixed_checkbox).append('<span>Fixar Rodapé</span>')
  $container.append($footer_fixed_container)

  //opçes de texto pequeno
  $container.append('<h6>Texto Pequeno</h6>')

  //texto_corpo
  var $text_sm_body_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('body').hasClass('text-sm'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      //$('body').addClass('text-sm')
      location.href = 'https://' + window.location.hostname + '/assets/customizar/gravar_customizacao.php?customizar=texto_corpo&old_url=' + window.location.href;
    } else {
      //$('body').removeClass('text-sm')
      location.href = 'https://' + window.location.hostname + '/assets/customizar/gravar_customizacao.php?customizar=texto_corpo&old_url=' + window.location.href;
    }
  })
  var $text_sm_body_container = $('<div />', { class: 'mb-1' }).append($text_sm_body_checkbox).append('<span>Corpo</span>')
  $container.append($text_sm_body_container)

  //texto_barra_navegacao
  var $text_sm_header_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.main-header').hasClass('text-sm'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      //$('.main-header').addClass('text-sm')
      location.href = 'https://' + window.location.hostname + '/assets/customizar/gravar_customizacao.php?customizar=texto_barra_navegacao&old_url=' + window.location.href;
    } else {
      //$('.main-header').removeClass('text-sm')
      location.href = 'https://' + window.location.hostname + '/assets/customizar/gravar_customizacao.php?customizar=texto_barra_navegacao&old_url=' + window.location.href;
    }
  })
  var $text_sm_header_container = $('<div />', { class: 'mb-1' }).append($text_sm_header_checkbox).append('<span>Barra de navegação</span>')
  $container.append($text_sm_header_container)

  //texto_logotipo
  var $text_sm_brand_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.brand-link').hasClass('text-sm'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      //$('.brand-link').addClass('text-sm')
      location.href = 'https://' + window.location.hostname + '/assets/customizar/gravar_customizacao.php?customizar=texto_logotipo&old_url=' + window.location.href;
    } else {
      //$('.brand-link').removeClass('text-sm')
      location.href = 'https://' + window.location.hostname + '/assets/customizar/gravar_customizacao.php?customizar=texto_logotipo&old_url=' + window.location.href;
    }
  })
  var $text_sm_brand_container = $('<div />', { class: 'mb-1' }).append($text_sm_brand_checkbox).append('<span>Logo</span>')
  $container.append($text_sm_brand_container)

  //texto_barra_lateral
  var $text_sm_sidebar_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.nav-sidebar').hasClass('text-sm'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      //$('.nav-sidebar').addClass('text-sm')
      location.href = 'https://' + window.location.hostname + '/assets/customizar/gravar_customizacao.php?customizar=texto_barra_lateral&old_url=' + window.location.href;
    } else {
      //$('.nav-sidebar').removeClass('text-sm')
      location.href = 'https://' + window.location.hostname + '/assets/customizar/gravar_customizacao.php?customizar=texto_barra_lateral&old_url=' + window.location.href;
    }
  })
  var $text_sm_sidebar_container = $('<div />', { class: 'mb-1' }).append($text_sm_sidebar_checkbox).append('<span>Menu Lateral</span>')
  $container.append($text_sm_sidebar_container)

  //texto_rodape
  var $text_sm_footer_checkbox = $('<input />', {
    type: 'checkbox',
    value: 1,
    checked: $('.main-footer').hasClass('text-sm'),
    class: 'mr-1'
  }).on('click', function () {
    if ($(this).is(':checked')) {
      //$('.main-footer').addClass('text-sm')
      location.href = 'https://' + window.location.hostname + '/assets/customizar/gravar_customizacao.php?customizar=texto_rodape&old_url=' + window.location.href;
    } else {
      //$('.main-footer').removeClass('text-sm')
      location.href = 'https://' + window.location.hostname + '/assets/customizar/gravar_customizacao.php?customizar=texto_rodape&old_url=' + window.location.href;
    }
  })
  var $text_sm_footer_container = $('<div />', { class: 'mb-4' }).append($text_sm_footer_checkbox).append('<span>Rodapé</span>')
  $container.append($text_sm_footer_container)

  // Color Arrays

  var navbar_dark_skins = [
    'navbar-primary',
    'navbar-secondary',
    'navbar-info',
    'navbar-success',
    'navbar-danger',
    'navbar-indigo',
    'navbar-purple',
    'navbar-pink',
    'navbar-navy',
    'navbar-lightblue',
    'navbar-teal',
    'navbar-cyan',
    'navbar-dark',
    'navbar-gray-dark',
    'navbar-gray'
  ]

  var navbar_light_skins = [
    'navbar-light',
    'navbar-warning',
    'navbar-white',
    'navbar-orange'
  ]

  var sidebar_colors = [
    'bg-primary',
    'bg-warning',
    'bg-info',
    'bg-danger',
    'bg-success',
    'bg-indigo',
    'bg-lightblue',
    'bg-navy',
    'bg-purple',
    'bg-fuchsia',
    'bg-pink',
    'bg-maroon',
    'bg-orange',
    'bg-lime',
    'bg-teal',
    'bg-olive'
  ]

  var accent_colors = [
    'accent-primary',
    'accent-warning',
    'accent-info',
    'accent-danger',
    'accent-success',
    'accent-indigo',
    'accent-lightblue',
    'accent-navy',
    'accent-purple',
    'accent-fuchsia',
    'accent-pink',
    'accent-maroon',
    'accent-orange',
    'accent-lime',
    'accent-teal',
    'accent-olive'
  ]

  var sidebar_skins = [
    'sidebar-dark-primary',
    'sidebar-dark-warning',
    'sidebar-dark-info',
    'sidebar-dark-danger',
    'sidebar-dark-success',
    'sidebar-dark-indigo',
    'sidebar-dark-lightblue',
    'sidebar-dark-navy',
    'sidebar-dark-purple',
    'sidebar-dark-fuchsia',
    'sidebar-dark-pink',
    'sidebar-dark-maroon',
    'sidebar-dark-orange',
    'sidebar-dark-lime',
    'sidebar-dark-teal',
    'sidebar-dark-olive',
    'sidebar-light-primary',
    'sidebar-light-warning',
    'sidebar-light-info',
    'sidebar-light-danger',
    'sidebar-light-success',
    'sidebar-light-indigo',
    'sidebar-light-lightblue',
    'sidebar-light-navy',
    'sidebar-light-purple',
    'sidebar-light-fuchsia',
    'sidebar-light-pink',
    'sidebar-light-maroon',
    'sidebar-light-orange',
    'sidebar-light-lime',
    'sidebar-light-teal',
    'sidebar-light-olive'
  ]



  var navbar_all_colors = navbar_dark_skins.concat(navbar_light_skins)

//cor_barra_topo
  var barra_topo_skins = navbar_all_colors
  $container.append('<h6>Menu Esquerda</h6>')
  var $barra_topo_variants = $('<div />', {
    class: 'd-flex'
  })
  $container.append($barra_topo_variants)
  var $clear_btn = $('<a />', {
    href: '#'
  }).text('clear').on('click', function (e) {
    e.preventDefault()
    var $barra_topo = $('.main-header')
    barra_topo_skins.forEach(function (skin) {
      $barra_topo.removeClass(skin)
    })
  })

  var $barra_topo_variants = createSkinBlock(barra_topo_skins, function () {
    var color = $(this).data('color')
    var $barra_topo = $('.main-header')

    if (color === 'navbar-light' || color === 'navbar-white') {
      $barra_topo.addClass('text-black')
    } else {
      $barra_topo.removeClass('text-black')
    }

    barra_topo_skins.forEach(function (skin) {
      $barra_topo.removeClass(skin)
    })

    if (color) {
      $(this).parent().removeClass().addClass('custom-select mb-3 border-0').addClass(color).addClass(color !== 'navbar-light' && color !== 'navbar-white' ? 'text-light' : '')
      location.href = 'https://' + window.location.hostname + '/assets/customizar/gravar_customizacao.php?customizar=cor_barra_topo&cor=' + color + '&old_url=' + window.location.href;
    } else {
      //$(this).parent().removeClass().addClass('custom-select mb-3 border-0')
      location.href = 'https://' + window.location.hostname + '/assets/customizar/gravar_customizacao.php?customizar=cor_barra_topo&cor=' + color + '&old_url=' + window.location.href;
    }

    $barra_topo.addClass(color)
  }, true).append($clear_btn)
  $container.append($barra_topo_variants)

 var active_barra_topo_color = null
  $('.main-header')[0].classList.forEach(function (className) {
    if (barra_topo_skins.indexOf(className) > 1 ) {
      active_barra_topo_color = className.replace('navbar-', 'bg-')
    }
  })

  if (active_barra_topo_color) {
    $barra_topo_variants.find('option.' + active_barra_topo_color).prop('selected', true)
    $barra_topo_variants.removeClass().addClass('custom-select mb-3 text-light border-0 ').addClass(active_barra_topo_color)
  }



/*

  //cor_barra_topo
  $container.append('<h6>Barra Topo</h6>')
  var $navbar_variants = $('<div />', {
    class: 'd-flex'
  })
  var navbar_all_colors = navbar_dark_skins.concat(navbar_light_skins)
  var $navbar_variants_colors = createSkinBlock(navbar_all_colors, function () {
    var color = $(this).data('color')
    var $main_header = $('.main-header')
    //$main_header.removeClass('navbar-dark').removeClass('navbar-light')
    navbar_all_colors.forEach(function (color) {
      //$main_header.removeClass(color)
    })

    $(this).parent().removeClass().addClass('custom-select mb-3 text-light border-0 ')

    if (navbar_dark_skins.indexOf(color) > -1) {
      //$main_header.addClass('navbar-dark')
      $(this).parent().addClass(color).addClass('text-light')
      //alert(color);
      location.href = 'https://' + window.location.hostname + '/assets/customizar/gravar_customizacao.php?customizar=cor_barra_topo&cor=' + color + '&old_url=' + window.location.href;
    } else {
      //$main_header.addClass('navbar-light')
      $(this).parent().addClass(color)
      location.href = 'https://' + window.location.hostname + '/assets/customizar/gravar_customizacao.php?customizar=cor_barra_topo&cor=' + color + '&old_url=' + window.location.href;
    }

    $main_header.addClass(color)
  })


  var active_navbar_color = null
  $('.main-header')[0].classList.forEach(function (className) {
    if (navbar_all_colors.indexOf(className) > -1 && active_navbar_color === null) {
      active_navbar_color = className.replace('navbar', 'bg-')
    }
  })

  $navbar_variants_colors.find('option.' + active_navbar_color).prop('selected', true)
  $navbar_variants_colors.removeClass().addClass('custom-select mb-3 text-light border-0 ').addClass(active_navbar_color)

  $navbar_variants.append($navbar_variants_colors)

  $container.append($navbar_variants)
  */






//cor_menu_esquerda
  var menu_esquerda_skins = navbar_all_colors
  $container.append('<h6>Menu Esquerda</h6>')
  var $menu_esquerda_variants = $('<div />', {
    class: 'd-flex'
  })
  $container.append($menu_esquerda_variants)
  var $clear_btn = $('<a />', {
    href: '#'
  }).text('clear').on('click', function (e) {
    e.preventDefault()
    var $menu_esquerda = $('.menu_esquerda-link')
    menu_esquerda_skins.forEach(function (skin) {
      $menu_esquerda.removeClass(skin)
    })
  })

  var $menu_esquerda_variants = createSkinBlock(menu_esquerda_skins, function () {
    var color = $(this).data('color')
    var $menu_esquerda = $('.menu_esquerda-link')

    if (color === 'navbar-light' || color === 'navbar-white') {
      $menu_esquerda.addClass('text-black')
    } else {
      $menu_esquerda.removeClass('text-black')
    }

    menu_esquerda_skins.forEach(function (skin) {
      $menu_esquerda.removeClass(skin)
    })

    if (color) {
      //$(this).parent().removeClass().addClass('custom-select mb-3 border-0').addClass(color).addClass(color !== 'navbar-light' && color !== 'navbar-white' ? 'text-light' : '')
      location.href = 'https://' + window.location.hostname + '/assets/customizar/gravar_customizacao.php?customizar=cor_menu_esquerda&cor_menu_esquerda=' + color + '&old_url=' + window.location.href;
    } else {
      //$(this).parent().removeClass().addClass('custom-select mb-3 border-0')
      location.href = 'https://' + window.location.hostname + '/assets/customizar/gravar_customizacao.php?customizar=cor_menu_esquerda&cor_menu_esquerda=' + color + '&old_url=' + window.location.href;
    }

    $menu_esquerda.addClass(color)
  }, true).append($clear_btn)
  $container.append($menu_esquerda_variants)

 var active_menu_esquerda_color = null
  $('.menu_esquerda-link')[0].classList.forEach(function (className) {
    if (menu_esquerda_skins.indexOf(className) > -1 && active_menu_esquerda_color === null) {
      active_menu_esquerda_color = className.replace('navbar-', 'bg-')
    }
  })

  if (active_menu_esquerda_color) {
    $menu_esquerda_variants.find('option.' + active_menu_esquerda_color).prop('selected', true)
    $menu_esquerda_variants.removeClass().addClass('custom-select mb-3 text-light border-0 ').addClass(active_menu_esquerda_color)
  }




  //cor_logo
  var logo_skins = navbar_all_colors
  $container.append('<h6>Logo</h6>')
  var $logo_variants = $('<div />', {
    class: 'd-flex'
  })
  $container.append($logo_variants)
  var $clear_btn = $('<a />', {
    href: '#'
  }).text('clear').on('click', function (e) {
    e.preventDefault()
    var $logo = $('.brand-link')
    logo_skins.forEach(function (skin) {
      $logo.removeClass(skin)
    })
  })

  var $brand_variants = createSkinBlock(logo_skins, function () {
    var color = $(this).data('color')
    var $logo = $('.brand-link')

    if (color === 'navbar-light' || color === 'navbar-white') {
      $logo.addClass('text-black')
    } else {
      $logo.removeClass('text-black')
    }

    logo_skins.forEach(function (skin) {
      $logo.removeClass(skin)
    })

    if (color) {
      //$(this).parent().removeClass().addClass('custom-select mb-3 border-0').addClass(color).addClass(color !== 'navbar-light' && color !== 'navbar-white' ? 'text-light' : '')
      location.href = 'https://' + window.location.hostname + '/assets/customizar/gravar_customizacao.php?customizar=cor_logo&cor_logo=' + color + '&old_url=' + window.location.href;
    } else {
      //$(this).parent().removeClass().addClass('custom-select mb-3 border-0')
      location.href = 'https://' + window.location.hostname + '/assets/customizar/gravar_customizacao.php?customizar=cor_logo&cor_logo=' + color + '&old_url=' + window.location.href;
    }

    $logo.addClass(color)
  }, true).append($clear_btn)
  $container.append($brand_variants)

  var active_brand_color = null
  $('.brand-link')[0].classList.forEach(function (className) {
    if (logo_skins.indexOf(className) > -1 && active_brand_color === null) {
      active_brand_color = className.replace('navbar-', 'bg-')
    }
  })

  if (active_brand_color) {
    $brand_variants.find('option.' + active_brand_color).prop('selected', true)
    $brand_variants.removeClass().addClass('custom-select mb-3 text-light border-0 ').addClass(active_brand_color)
  }
})(jQuery)
