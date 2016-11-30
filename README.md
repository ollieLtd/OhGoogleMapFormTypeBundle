OhGoogleMapFormTypeBundle
=========================

Set latitude and longitude values on a form using Google Maps. The map includes a search field and a current location link. When a pin is placed or dragged on the map, the latitude and longitude fields are updated.

Installation
------------

This bundle is compatible with Symfony 2.1. Add the following to your `composer.json`:

    "oh/google-map-form-type-bundle": "dev-master"

or execute: 

    php composer.phar require oh/google-map-form-type-bundle

Register the bundle in your `app/AppKernel.php`:

```php
// app/AppKernel.php
public function registerBundles()
    {
        $bundles = array(
            new Oh\GoogleMapFormTypeBundle\OhGoogleMapFormTypeBundle(),
            // ...
```

You might need to change a couple of options if you are trying to use Symfony 2.0

Add OhGoogleMapFormTypeBundle to assetic
```yaml
# app/config/config.yml
# Assetic Configuration
assetic:
    bundles:        [ 'OhGoogleMapFormTypeBundle' ]
```
After this, you have to install assets:

    php app/console assets:install --symlink

Usage
-------

This bundle contains a new FormType called GoogleMapType which can be used in your forms like so:

    $builder->add('latlng', 'oh_google_maps');

On your model you will have to process the latitude and longitude array
``` php
// Your model eg, src/My/Location/Entity/MyLocation.php
use Symfony\Component\Validator\Constraints as Assert;
use Oh\GoogleMapFormTypeBundle\Validator\Constraints as OhAssert;

class MyLocation
{
    // ... include your lat and lng fields here

    public function setLatLng($latlng)
    {
        $this->setLat($latlng['lat']);
        $this->setLng($latlng['lng']);
        return $this;
    }

    /**
     * @Assert\NotBlank()
     * @OhAssert\LatLng()
     */
    public function getLatLng()
    {
        return array('lat'=>$this->getLat(),'lng'=>$this->getLng());
    }

}
```

**Add form_javascript** this principle is to separate the javascript and html. This allows better integration of web pages. Inspired by its use [DatetimepickerBundle](https://github.com/stephanecollot/DatetimepickerBundle)

### Example:

``` twig
{% block javascripts %}
    <script src="{{ asset('js/other.js') }}"></script>
    
    {{ form_javascript(form) }}
{% endblock %}

{% block body %}
    <form action="{{ path('my_route_form') }}" type="post" {{ form_enctype(form) }}>
        {{ form_widget(form) }}

        <input type="submit" />
    </form>
{% endblock %}
```

Options
-------

There are a number of options, mostly self-explanatory

``` php
array(
	'type'           => 'text',  // the types to render the lat and lng fields as
	'options'        => array(), // the options for both the fields
	'lat_options'  => array(),   // the options for just the lat field
	'lng_options' => array(),    // the options for just the lng field
	'lat_name'       => 'lat',   // the name of the lat field
	'lng_name'       => 'lng',   // the name of the lng field
	'map_width'      => '100%',     // the width of the map, you must include units (ie, px or %)
	'map_height'     => '300px',     // the height of the map, you must include units (ie, px or %)
	'default_lat'    => 51.5,    // the starting position on the map
	'default_lng'    => -0.1245, // the starting position on the map
	'include_jquery' => false,   // jquery needs to be included above the field (ie not at the bottom of the page)
	'include_gmaps_js'=>true,    // is this the best place to include the google maps javascript?
	'js_inside_html' => false    // if you don't have the possibility to include form_javascript(), ie, in Sonata Admin Class, set true this option
)
```
	
### Twig customization:
You have 2 twig templates for the layout, for HTML and for JQUERY (js). It's generally a good idea to overwrite the form templates, especially HTML, in your own twig template. Place them on folder: `app/Resources/OhGoogleMapFormTypeBundle/views/Form/`

 - HTML: `vendor/oh/google-map-form-type-bundle/Oh/GoogleMapFormTypeBundle/Resources/views/Form/div_layout.html.twig`
 - JQUERY (js): `vendor/oh/google-map-form-type-bundle/Oh/GoogleMapFormTypeBundle/Resources/views/Form/jquery_layout.html.twig`

If you are intending to override some of the elements in the template JQUERY (js), then you can do so by extending the default `jquery_layout.html.twig`. This example adds a callback to the javascript when a new map position is selected.

``` twig
{# your template which is inluded in app/Resources/OhGoogleMapFormTypeBundle/views/Form/ folder (above) #}
{% extends "OhGoogleMapFormTypeBundle:Form:jquery_layout.html.twig" %}
{% block oh_google_maps_callback %}
		<script type="text/javascript">
			var oh_google_maps_callback = function(location, gmap){
                // logs to the console your new latitude
				console.log('Your new latitude is: '+location.lat());
			}
		</script>	
{% endblock %}
```

If you have several forms with `oh_google_maps` types, you can override the templates in each one of them with `{% form_theme form 'AppBundle:Forms:your-twig.html.twig' %}` like this:

``` twig
{% extends 'form_div_layout.html.twig' %}

{% block oh_google_maps_html %} 
        <div id="{{ id }}_container">
            <input type="text" id="{{ id }}_input" /><button id="{{ id }}_search_button" class="btn">Search</button><br /><a href="#" id="{{ id }}_current_position">MY CUSTOM TEXT FOR CURRENT LOCATION</a>
            <div id="{{ id }}_map_canvas" class="gmap" style="width: {{ map_width }}; height: {{ map_height }}"></div>
            <div id="{{ id }}_error"></div>
        </div>
{% endblock %}
```


Screenshots
-------

[Default form](https://www.dropbox.com/s/pvoihkkq74imnk3/location-form-1.png)
[Current position](https://www.dropbox.com/s/uhf7fk3mx35j137/location-form-current.png)
[Search locations](https://www.dropbox.com/s/qdft149ggyfil0p/location-form-search.png)
[LatLng validation](https://www.dropbox.com/s/k0xqku5q2gv2nlo/location-form-validation.png)

Credits
-------

* Ollie Harridge (ollietb) as main author.
