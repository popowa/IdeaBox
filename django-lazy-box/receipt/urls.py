from django.conf.urls.defaults import patterns, include, url

urlpatterns = patterns('receipt.views',
    url(r'^$', "receipt_index", name="receipt_index"),
    url(r'^list/$', "receipt_list", name="receipt_list"),
    url(r'^facebook/(?P<url>[a-zA-Z0-9_.-]+)/$', "receipt_facebook_page", name="receipt_facebook_page"),
    url(r'^pdf/$', "receipt_print_pdf", name="receipt_print_pdf"),

    
)
