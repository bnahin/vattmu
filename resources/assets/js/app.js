require('./bootstrap')

/* * * * * * * * * * * * * *
 *                         *
 *  Custom JS             *
 *  Author: Blake Nahin    *
 *                         *
 * * * * * * * * * * * * * */

/** General **/
$(document, 'div.flash-alert').not('.alert-important').delay(3000).fadeOut(500)

/** Weather **/
if ($('#metar-search').length) {
  $(document).ajaxStart(function () { Pace.restart() })

  $('#metar-search-submit').click(function () {
    $('#search-error').remove()
    $('#airport-block').hide()

    let ap  = $('#metar-airport'),
        val = ap.val()
    ap.parent().removeClass('has-error')
    if (!val.length || val.length > 4 || val.length < 3) {
      return $('#metar-box').find('#search-col').prepend('<div class="callout callout-danger flash-alert" id="search-error">' +
        '<i class="fas fa-exclamation-triangle"></i> <strong>Error!</strong> A valid airport code is required.</div>')
    }
    $('#metar-box').append('<div class="overlay"><i class="fa fas fa-sync-alt fa-spin"></i></div>')
    let icao = $('#metar-airport').val()
    $.ajax({
      type   : 'POST',
      url    : '/weather/metar',
      data   : {airport: icao},
      success: function (data) {
        let box = $('#metar-box')
        box.find('.overlay').remove()
        box.find('#raw-metar').text(data.raw)
        box.find('#taf').html(data.taf)

        $('#ap-name').text(data.name)
        $('#ap-city').text(data.city)
        $('#airport-block').show()

        let dec = data.dec
        box.find('#cat').html(dec.cat)
        box.find('#wind').html(dec.wind)
        box.find('#cond').html(dec.visibility)
        box.find('#clouds').html(dec.clouds)
        box.find('#temp').html(dec.tempBlock)
        box.find('#baro').html(dec.baro)
      },
      error  : function (xhr, status, err) {
        let box = $('#metar-box')
        if (!xhr.responseJSON.hasOwnProperty('errors')) {
          box.find('.overlay').remove()
          return box.find('#search-col').prepend('<div class="callout callout-danger flash-alert" id="search-error">' +
            '<i class="fas fa-exclamation-triangle"></i> <strong>Error!</strong> A server error has occured.</div>')
        }
        let errText = xhr.responseJSON.errors.airport[0]
        box.find('#search-col').prepend('<div class="callout callout-danger flash-alert" id="search-error">' +
          '<i class="fas fa-exclamation-triangle"></i> <strong>Error!</strong> ' + errText + '</div>')
        box.find('.overlay').remove()
      }
    })
  })
  $('#metar-airport').keypress(function (e) {
    if (e.which == 13) {
      $('#metar-search-submit').click()
    }
  })

}