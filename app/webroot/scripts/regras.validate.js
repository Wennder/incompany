    jQuery.validator.addMethod("selectRequerido", function(value, element, params) {
    return this.optional(element) || value > params;
     });