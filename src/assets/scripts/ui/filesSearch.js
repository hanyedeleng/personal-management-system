/**
 * This file handles top bar searching for files. Supports:
    * searching by tags
 */
var bootbox = require('bootbox');

export default (function () {

    if (typeof window.filesSearch === 'undefined') {
        window.ui.filesSearch = {};
    }

    ui.filesSearch = {

        selectors: {
            ids: {
                filesSearchByTagsInput  : "#filesSearchByTags",
                fileSearchResultWrapper : "#searchResultListWrapper"
            },
            classes: {
            },
            other: {
            }
        },
        messages: {
        },
        methods: {
            getSearchResultsDataForTag: '/api/search/get-results-data'
        },
        vars: {
        },
        init: function(){
            this.attachAjaxCallOnChangeOfSearchInput();
        },
        attachAjaxCallOnChangeOfSearchInput: function(){

            let _this                  = this;
            let filesSearchByTagsInput = $(this.selectors.ids.filesSearchByTagsInput);

            filesSearchByTagsInput.on('change', () => {

                let tags = $(filesSearchByTagsInput).val();

                let data = {
                    'tags' : tags
                };

                // this is used to prevent instant search whenever new character is inserted in search input
                // TODO: prevent stacking the timeouted calls - break previous if new is being sent
                setTimeout( () => {
                    $.ajax({
                        method  : "POST",
                        url     : _this.methods.getSearchResultsDataForTag,
                        data    : data
                    }).always((data)=>{

                        let resultsCount = data['searchResults'].length;

                        if( 0 === resultsCount ){
                            return;
                        }

                        let searchResultsList       = _this.buildSearchResultsList(data['searchResults']);
                        let fileSearchResultWrapper = $(_this.selectors.ids.fileSearchResultWrapper);

                        $(fileSearchResultWrapper).empty();
                        $(fileSearchResultWrapper).append(searchResultsList);
/*

                        let selector = '.search-input .selectize-control + #searchResultListWrapper ul';
                        $('.search-input .selectize-control').on('mouseover', () => {
                                $(selector).slideDown();
                            }

                        );

                        $('.search-input .selectize-control').on('mouseout', () => {
                                $(selector).slideUp();
                            }
                        );
*/


                    })
                }, 2000)

            });


        },
        buildSearchResultsList: function (data) {

            let ul = $('<ul>');

            $(ul).css({
                'background-color': 'white',
                'list-style-type': 'none',
                'margin': '0',
                'padding': '5px'
            });

            $.each(data, (index, result) => {
                let module   = result['module'];
                let filename = result['filename'];
                let filePath = result['fullFilePath'];

                let form = $('<form>');
                $(form).attr('method', "POST");
                $(form).attr('action', "/download/file");
                $(form).addClass('file-download-form d-inline');
                $(form).css({
                    "float": "right"
                });

                let input = $('<input>');
                $(input).attr('type','hidden');
                $(input).attr('name','file_full_path');
                $(input).val(filePath);

                let button = $('<button>');
                $(button).addClass('file-download d-inline');
                $(button).css({
                    'background': 'none',
                    'padding'   : '0',
                    'border'    : 'none'
                });

                let downloadIcon = $('<i>');
                $(downloadIcon).addClass('fa fa-download');
                $(button).css({
                    'padding-left': '10px'
                });

                $(button).append(downloadIcon);
                $(form).append(input);
                $(form).append(button);

                let moduleIcon = $('<span>');
                $(moduleIcon).css({
                    "padding-right": "5px"
                });

                if( 'My Images' === module ){
                    $(moduleIcon).addClass('fas fa-folder-open d-inline');
                }else if( 'My Files' === module ){
                    $(moduleIcon).addClass('fas fa-image d-inline');
                }

                let name = $('<span>');
                $(name).html(filename);
                $(name).css({"padding-right": "5px"});
                $(name).addClass("d-inline");

                let li = $('<li>');
                $(li).append(moduleIcon);
                $(li).append(name);
                $(li).append(form);

                $(ul).append(li);
            });

            return ul;

        }
    };

}());