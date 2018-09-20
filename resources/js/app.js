var api_key = 'b616193ba38eec32e0603fae57f97cbe';

window.showResult = showResult;

function showResult(str){
    $(document).ready(function(){

        var column = '';
        if(!str){
          $('.search_results').children().remove();
        }
      $.ajax({
        url: 'http://api.themoviedb.org/3/search/tv?api_key=' + api_key + '&query='+str,
        dataType: 'jsonp',

      }).done(function(response) {
		  $('.search_results').children().remove();
          $('.search_results').show();

        for (var i = 0; i < (response['total_results'] >= 4 ? 4 : response.results.length); i++) {
          var id = response.results[i].id;
        	var name = response.results[i].name;
        	var first_air_date = response.results[i].first_air_date;
        	var posterPath = response.results[i].poster_path;

        	first_air_date = first_air_date.substring(0, first_air_date.indexOf('-'));

          if(posterPath == null){continue;}

          column += '<a href="/tvshows?id='+id+'"><div class="row no-gutters search_row"><div class="col search_column"><img src="http://image.tmdb.org/t/p/w185/'+posterPath+'"><p>'+name+'   ('+first_air_date+')</p></div></div></a>';
          $('.search_results').append(column);
          column = '';
        }
      })
      .fail(function( jqxhr, textStatus, error ) {
        var err = textStatus + ", " + error;
        console.log( "Request Failed: " + err );
    });
    });
}
