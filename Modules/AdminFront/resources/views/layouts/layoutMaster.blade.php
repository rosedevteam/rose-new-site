@isset($pageConfigs)
@endisset

@isset($configData["layout"])
@include((( $configData["layout"] === 'horizontal') ? 'adminfront::layouts.horizontalLayout' :
(( $configData["layout"] === 'blank') ? 'adminfront::layouts.blankLayout' : 'adminfront::layouts.contentNavbarLayout') ))
@endisset
