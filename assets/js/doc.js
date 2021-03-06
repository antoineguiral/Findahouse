// NOTICE!! DO NOT USE ANY OF THIS JAVASCRIPT
// IT'S ALL JUST JUNK FOR OUR DOCS!
// ++++++++++++++++++++++++++++++++++++++++++

!function ($) {

    $(function(){

        // fix sub nav on scroll
        var $win = $(window)
        , $nav = $('.subnav')
        , navTop = $('.subnav').length && $('.subnav').offset().top - 40
        , isFixed = 0

        processScroll()

        $win.on('scroll', processScroll)

        function processScroll() {
            var i, scrollTop = $win.scrollTop()
            if (scrollTop >= navTop && !isFixed) {
                isFixed = 1
                $nav.addClass('subnav-fixed')
            } else if (scrollTop <= navTop && isFixed) {
                isFixed = 0
                $nav.removeClass('subnav-fixed')
            }
        }


   
    


    })

}(window.jQuery)

$(document).ready(function(){
    id=window.location.hash.replace('#','')
    if(id != ''){
        showHouse(id)
    }


    $.getJSON('api.php/house/all', {}, function(json){
        
        
        var allMarkers=[];
        
        for (var i = 0, ii = json.length; i < ii; i++){
            
            marker = {
                lat: json[i].latLng.lat,
                lng: json[i].latLng.lon,
                data: json[i].id
            }
            allMarkers.push(marker);
        }
        $('#map-global').gmap3(
          {action:'init',
            options:{
              center:[46.578498,2.457275],
              zoom: 5
            }
          },
          {action: 'addMarkers',
            markers:allMarkers,
            marker:{
              options:{
                draggable: false
              },
              events:{
                  click: function(marker, event, data){
                      showHouse(data);
                      window.location.hash=data
                  }
                
                }
              }
            },
                "autofit"
          
        );
    })

    




//    $("#map-adding-house").gmap3();
 
    $('#address-adding-house').autocomplete({
        source: function() {
            $("#map-adding-house").gmap3({
                action:'getAddress',
                address: $(this).val(),
                callback:function(results){
                    if (!results) return;
                    $('#address-adding-house').autocomplete(
                        'display',
                        results,
                        false
                        );
                }
            });
        },
        cb:{
            cast: function(item){
                return item.formatted_address;
            },
            select: function(item) {
                form = $('#form-adding-house')
                for(var i = 0, ii = item.address_components.length; i < ii; i++ ){
                    form.append($('<input type="hidden" name="address_components['+i+'][short_name]" value="'+item.address_components[i].short_name+'"/>'))
                    form.append($('<input type="hidden" name="address_components['+i+'][long_name]" value="'+item.address_components[i].long_name+'"/>'))
                }
                form.append($('<input type="hidden" name="formatted_address" value="'+item.formatted_address+'"/>'))
                form.append($('<input type="hidden" name="latLng[lat]" value="'+item.geometry.location.lat()+'"/>'))
                form.append($('<input type="hidden" name="latLng[lon]" value="'+item.geometry.location.lng()+'"/>'))
//                $("#map-adding-house").gmap3({
//                    action:'clear', 
//                    name:'marker'
//                },{
//                    action:'addMarker',
//                    latLng:item.geometry.location,
//                    map:{
//                        center:true
//                    }
//                },
//                "autofit" 
//                );
            }
        }
    });

    $('#add-house').click(function(){
        $.post('api.php/house/create',$('#form-adding-house').serialize(),function(json){
               location.reload()
        })
    })
    
    $('.input-photos:last').live('focus',function(){
        newPhotos=$(this).clone()
        $(this).parent().append(newPhotos)
    })
    
    $('.edit-house').live('click',function(){
        id=$(this).attr('id').replace('house-','')
        editHouse(id)
    })
    $('.save').live('click',function(){
        var id=$(this).attr('id').replace('save-','')
        form=$(this).parents('form')
        $.post('api.php/house/'+id,form.serialize(),function(json){
               showHouse(id)
        })
        return false;
    })
    $('.cancel').live('click',function(){
        id=$(this).attr('id').replace('cancel-','')
        showHouse(id)
        return false;
    })
})

showHouse = function(id){
    $.getJSON('api.php/house/'+id, {}, function(json){
        house=$('#template-house').tmpl(json)
        $('#house').html(house)
        $('#house').find('#myCarousel .item:first').addClass('active')
    })
}
editHouse = function(id){
    $.getJSON('api.php/house/'+id, {}, function(json){
        house=$('#template-house-edit').tmpl(json)
        $('#house').html(house)
    })
}