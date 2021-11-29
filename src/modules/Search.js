import $ from 'jquery';

class Search {
  // 1. Describe and create/initiate object
  constructor() {
    this.addSearcHTML();
    this.resultsDiv = $('#search-overlay__results');
    this.openButton = $('.js-search-trigger');
    this.closeButton = $('.search-overlay__close');
    this.searchOverlay = $('.search-overlay');
    this.searchField = $('#search-term');
    this.previousValue;
    this.isOverlayOpen = false;
    this.isSpinnerVisible = false;
    this.typingTimer;
    this.events();
  }

  /********************* 2. Events Methods (Beginning) *********************/
  ///////////////////////////// NEW EVENT METHOD //////////////////////////////////////////////////
  events() {
    this.openButton.on('click', this.openOverlay.bind(this));
    this.closeButton.on('click', this.closeOverlay.bind(this));
    this.searchField.on('keyup', this.typingLogic.bind(this));
    $(document).on('keydown', this.keyPressDispatcher.bind(this));
  }
  /********************* 2. Events Methods (Ending) *********************/

  ////////////////////////////////////////////////////////////////////////////////////////////////////

  /********************* 3. Action Methods (Beginning)  *********************/
  ///////////////////////////// NEW ACTION METHOD //////////////////////////////////////////////////
  typingLogic(e) {
    if (this.searchField.val() != this.previousValue) {
      clearTimeout(this.typingTimer);

      if (this.searchField.val()) {
        if (!this.isSpinnerVisible) {
          this.resultsDiv.html(`<div class="spinner-loader"></div>`);
          this.isSpinnerVisible = true;
        }
        this.typingTimer = setTimeout(this.getResults.bind(this), 750);
      } else {
        this.resultsDiv.html('');
        this.isSpinnerVisible = false;
      }
    }
    this.previousValue = this.searchField.val();
  }

  ///////////////////////////// NEW ACTION METHOD //////////////////////////////////////////////////
  getResults() {
    $.getJSON(
      universityData.root_url +
        '/wp-json/university/v1/search?term=' +
        this.searchField.val(),
      (results) => {
        this.resultsDiv.html(`
      <div class='row'>
      
      ${/********* Posts and Pages ******************/ ''}
      <div class='one-third'>
      <h2 class="search-overlay__section-title">General Information</h2>
      ${
        results.generalInfo.length
          ? '<ul class="link-list min-list">'
          : `<p>No genral information matches that search</p> <a href="${universityData.root_url}/blog">View all</a>`
      }
      ${results.generalInfo
        .map(
          (item) =>
            `<li><a href="${item.permalink}">${item.title}</a> ${
              item.type == 'post' || item.type == 'page'
                ? ` By ${item.authorName} `
                : ''
            }</li>`
        )
        .join('')}
      ${results.generalInfo.length ? '</ul>' : ''}
      </div>

      ${
        /***********************************************************************/ ''
      }

      ${/********* Programs an Professors ******************/ ''}
      <div class='one-third'> 
      <h2 class="search-overlay__section-title">Programs</h2>
      ${
        results.programs.length
          ? '<ul class="link-list min-list">'
          : `<p>No programs matches that search</p> <a href="${universityData.root_url}/programs">View all programs</a>`
      }
      ${results.programs
        .map((item) => `<li><a href="${item.permalink}">${item.title}</a></li>`)
        .join('')}
      ${results.programs.length ? '</ul>' : ''}

      <h2 class="search-overlay__section-title">Professors</h2>
      ${
        results.professors.length
          ? '<ul class="link-list min-list">'
          : `<p>No professors matches that search</p>`
      }
      ${results.professors
        .map(
          (item) => `
      <li class="professor-card__list-item">
          <a class="professor-card" href="${universityData.root_url}/programs">
            <img class="professor-card__image" src="${item.image}">
            <span class="professor-card__name">${item.title}</span>
          </a>
        </li>
      `
        )
        .join('')}
      ${results.professors.length ? '</ul>' : ''}
      </div>
      
      ${
        /***********************************************************************/ ''
      }

      ${/********* Campuses and Events ******************/ ''}
      <div class='one-third'> 
      <h2 class="search-overlay__section-title">Campuses</h2>
      ${
        results.campuses.length
          ? '<ul class="link-list min-list">'
          : `<p>No campuses matches that search</p> <a href="${universityData.root_url}/campus-locations">View all campuses</a>`
      }
      ${results.campuses
        .map((item) => `<li><a href="${item.permalink}">${item.title}</a></li>`)
        .join('')}
      ${results.campuses.length ? '</ul>' : ''}
      
      <h2 class="search-overlay__section-title">Events</h2>
      ${
        results.events.length
          ? ''
          : `<p>No events matches that search</p> <a href="${universityData.root_url}/events">View all events</a>`
      }
      ${results.events
        .map(
          (item) => `
      <div class="event-summary">
          <a class="event-summary__date t-center" href="${item.permalink}">
            <span class="event-summary__month">${item.month}</span>
            <span class="event-summary__day">${item.day}</span>
          </a>
          <div class="event-summary__content">
            <h5 class="event-summary__title headline headline--tiny"><a href="${item.permalink}">${item.title}</a></h5>
            <p>${item.description} <a href="${item.permalink}" class="nu gray">Learn more</a></p>
          </div>
      </div>
      `
        )
        .join('')}
      
      </div>
      </div>
      `);
        this.isSpinnerVisible = false;
      }
    );
  }

  ///////////////////////////// NEW ACTION METHOD //////////////////////////////////////////////////
  keyPressDispatcher(e) {
    if (
      e.keyCode == 83 &&
      !this.isOverlayOpen &&
      !$('input, textarea').is(':focus')
    ) {
      this.openOverlay();
    }

    if (e.keyCode == 27 && this.isOverlayOpen) {
      this.closeOverlay();
    }
  }

  ///////////////////////////// NEW ACTION METHOD //////////////////////////////////////////////////
  openOverlay() {
    this.searchOverlay.addClass('search-overlay--active');
    this.searchField.val('');
    setTimeout(() => this.searchField.trigger('focus'), 100);
    $('body').addClass('body-no-scroll');
    console.log('Our overlay is open');
    this.isOverlayOpen = true;
  }

  ///////////////////////////// NEW ACTION METHOD //////////////////////////////////////////////////
  closeOverlay() {
    this.searchOverlay.removeClass('search-overlay--active');
    $('body').removeClass('body-no-scroll');
    this.resultsDiv.html(`" "`);
    console.log('Our overlay is closed');
    this.isOverlayOpen = false;
  }

  ///////////////////////////// NEW ACTION METHOD //////////////////////////////////////////////////
  addSearcHTML() {
    $('body').append(`
    <div class='search-overlay'>
      <div class='search-overlay_top'>
        <div class='container'>
        <i class="fa fa-search search-overlay__icon" aria-hidden="false"></i>
        <input type="text" id="search-term" class="search-term" placeholder="What are you looking for?" autocomplete="off" autofocus>
        <i class="fa fa-window-close search-overlay__close" aria-hidden="false"></i>
        </div>
        
          <div class='container'>
          <h2 class='headline headling--medium'>Search Results</h2>
          <div id="search-overlay__results">
          
          </div>
        </div>
      </div>
    </div>
    `);
  }
  ///////////////////////////////////////////////////////////////////////////////

  /********************* 3. Action Methods (Ending)  *********************/
}

export default Search;
