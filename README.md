CookieConsentBundle
==============

## Installation

    composer require ekyna/cookie-consent-bundle
    
#### Register bundle and routes

```php
// app/AppKernel.php
public function registerBundles()
{
    $bundles = [
        // ...
        new Ekyna\Bundle\CookieConsentBundle\EkynaCookieConsentBundle(),
    ];
    // ...
}
```

```yaml
# app/config/routing.yml
ekyna_cookie_consent:
    resource: "@EkynaCookieConsentBundle/Resources/config/routing.yaml"
```

#### Use twig functions

```twig
{# base.html.twig #}
<!DOCTYPE html>
<html lang="en">
<head>
  <link href="{{ asset('bundles/ekynacookieconsent/css/cookie-consent.css') }}" rel="stylesheet" type="text/css" />
<head>
<body>
  {# ... #}
  
  {% block javascripts %}
    {# Renders the cookie consent widget (if not yet consented) #}
    {{ ekyna_cookie_consent_render() }}
    
    {# Check if cookie category has user consent ('analytic', 'marketing' or 'social_network') #}
    {% if ekyna_cookie_consent_category_allowed('analytic') %}
      <script src="https://example.org/analytic.js"></script>
    {% endif %}
  {% endblock javascripts %}
</body>
</html>
```

_ekyna_cookie_consent_render()_ options with their default values:

```twig
{{ ekyna_cookie_consent_render({
    render_if_saved: false, // Whether to render even if consent has been saved.
    expanded: false,        // Whether to show settings
    dialog: true            // Whether to render as a dialog/popup
}) }}
```


#### Configuration

Available configuration with default values.

```yaml
# app/config/config.yml
ekyna_cookie_consent:
    name: Cookie_Content   # The consent cookie name
    read_more_route: ~     # Route name to your privacy policy page
    position: centered     # Widget positioning ('centered' or 'bottom-right')
    categories:            # Cookies categories the user has to consent
        - analytic
        - marketing
        - social_network
    persist: true          # Whether to persist user consent
```


## TODO
* Encrypt cookie consent entity's __IP__ property. 
