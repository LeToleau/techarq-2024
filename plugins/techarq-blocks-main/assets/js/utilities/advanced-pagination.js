import Api from "./api";
import Debounce from "./debounce";

/**
 * This class adds the functionality to the AdvancedPagination module
 * See class AdvancedPagination located in 'inc/functionalities/advanced-pagination.php'
 * for further details
 */
class AdvancedPagination {
  /**
   * AdvancedPagination constructor
   * @param {HTMLElement} module
   */
  constructor(module) {
    // Pagination
    this.module = module;
    this.paginator = module.querySelector(".js-post-pagination");
    this.postType = this.paginator.getAttribute("post_type");
    this.postsContainer = this.module.querySelector(".js-posts");
    this.latestNews = module.querySelector(".js-latest-news");
    // console.debug(this.paginator);
    this.currentPage = parseInt(this.postsContainer.getAttribute("page"));
    this.pages = parseInt(this.postsContainer.getAttribute("pages"));
    this.loaderColor = this.postsContainer.getAttribute("loader_color");
    this.postsPerPage = parseInt(
      this.postsContainer.getAttribute("posts_per_page")
    );
    this.component = this.postsContainer.getAttribute("component");
    this.componentParent = this.postsContainer.getAttribute("component_parent");
    this.controllers = this.module.querySelector(
      ".js-pagination-controllers"
    );
    this.nothingFoundMessage = this.paginator.getAttribute(
      "no_results_message"
    );
    this.arrows;
    this.pageNumbersContainer;
    this.pageNumbers;
    this.pageNumbersLimit;

    // Filters
    this.taxonomiesBoxes = module.querySelectorAll(".js-posts-taxonomy");
    this.currentFilters = [];

    // Search
    this.searchInput = module.querySelector(".js-search-posts");
    this.searchValue = "";

    // Page Arguments
    this.href = window.location.href;

    // Check for Latest News block
    this.parentTag = this.paginator.parentElement;
    this.latestNews = this.parentTag.classList.contains("latest-news")
      ? this.parentTag.classList.contains("latest-news")
      : null;

    this.init();
  }
  /**
   * Here you should place the class methods that you want to execute
   */
  init() {
    console.log("holis!")
    if (this.setupControllerVars()) {
      this.arrowsClick();
      this.pageNumbersLimiter();
      this.pageNumbersClick();
    }

    this.checkArrowStatus();
    this.filters();
    this.searchPosts();
  }

  /**
   * This method prepares useful variables which then will be used
   * to handle pagination if the number of pages is greater than one
   * @return {boolean}
   */
  setupControllerVars() {
    if (this.pages > 1) {
      console.debug(this.controllers);
      this.arrows = {
        prev: this.controllers.querySelector(".js-back"),
        next: this.controllers.querySelector(".js-next"),
      };
      this.pageNumbersContainer = this.controllers.querySelector(".js-pages");
      this.pageNumbers = this.controllers.querySelectorAll(".js-page");
      this.pageNumbersLimit = parseInt(
        this.pageNumbersContainer.getAttribute("limit")
      );
      return true;
    } else {
      return false;
    }
  }
  /**
   * This method adds functionality to the arrows that control
   * the pagination
   */
  arrowsClick() {
    // Arrows or next, prev function
    const self = this;
    this.arrows.next.addEventListener("click", () => {
      if (self.currentPage < self.pages) {
        self.currentPage++;
        self.findCurrentButtonPage();
        self.postsContainer.setAttribute("page", self.currentPage);
        self.checkArrowStatus();
        self.call();
      }
    });

    this.arrows.prev.addEventListener("click", () => {
      if (self.currentPage > 1) {
        self.currentPage--;
        self.findCurrentButtonPage();
        self.postsContainer.setAttribute("page", self.currentPage);
        self.checkArrowStatus();
        self.call();
      }
    });
  }
  /**
   * This method adds the "active" class to the current page-btn
   */
  findCurrentButtonPage() {
    this.pageNumbers.forEach((button) => {
      button.classList.remove("active");

      if (button.getAttribute("page") == this.currentPage) {
        button.classList.add("active");
      }
    });
  }
  /**
   * This method handles the behavior of the page number buttons.
   * When a page number button is clicked it gets the active class
   * otherwise the active class is removed from it.
   * Also adds the functionality to each btn to make a request to the api.
   */
  pageNumbersClick() {
    const self = this;

    this.pageNumbers = this.module.querySelectorAll(".js-page");
    this.pageNumbers.forEach((button) => {
      button.addEventListener("click", () => {
        if (self.currentPage != parseInt(button.getAttribute("page"))) {
          self.pageNumbers.forEach((btn) => {
            btn.classList.remove("active");
          });
          button.classList.add("active");
          self.currentPage = parseInt(button.getAttribute("page"));
          self.checkArrowStatus();
          self.call();
        }
      });
    });
  }
  /**
   * This method handles the visibility of the pagination arrows
   */
  checkArrowStatus() {
    try {
      // Prev arrow
      if (this.currentPage == 1) {
        this.arrows.prev.classList.add("disabled");
      } else {
        this.arrows.prev.classList.remove("disabled");
      }

      // Next arrow
      if (this.currentPage == this.pages) {
        this.arrows.next.classList.add("disabled");
      } else {
        this.arrows.next.classList.remove("disabled");
      }
    } catch {}
  }
  /**
   * This method handles the visibility of the page number buttons
   */
  pageNumbersLimiter() {
    try {
      const from =
        this.currentPage - this.pageNumbersLimit <= 1
          ? 0
          : this.currentPage - this.pageNumbersLimit;
      const to =
        this.currentPage + this.pageNumbersLimit >= this.pages
          ? this.pages
          : this.currentPage + this.pageNumbersLimit;
      let firstHiddenBtn = true;

      this.pageNumbers.forEach((btn) => {
        if (
          parseInt(btn.getAttribute("page")) < from ||
          parseInt(btn.getAttribute("page")) > to
        ) {
          if (
            !btn.classList.contains("last-page") &&
            !btn.classList.contains("first-page")
          ) {
            btn.classList.add("hidden");
          }

          if (firstHiddenBtn) {
            firstHiddenBtn = false;
            if (parseInt(btn.getAttribute("page")) < from) {
              this.pageNumbersContainer.classList.add(
                "has-prev-hidden-buttons"
              );
            } else {
              this.pageNumbersContainer.classList.remove(
                "has-prev-hidden-buttons"
              );
            }
          }

          if (parseInt(btn.getAttribute("page")) > to) {
            this.pageNumbersContainer.classList.add("has-next-hidden-buttons");
          } else {
            this.pageNumbersContainer.classList.remove(
              "has-next-hidden-buttons"
            );
          }
        } else {
          if (
            !btn.classList.contains("last-page") &&
            !btn.classList.contains("first-page")
          ) {
            btn.classList.remove("hidden");
          }
        }
      });

      if (this.pageNumbers.length > this.pageNumbersLimit) {
        const lastBtn = this.pageNumbersContainer.querySelector(".last-page");
        const firstBtn = this.pageNumbersContainer.querySelector(".first-page");
        const lastSpan = this.pageNumbersContainer.querySelector(
          "span:not(.dots)"
        );
        const prepend = this.pageNumbersContainer.querySelector(".dots");

        if (!lastBtn && !lastSpan && !prepend && !firstBtn) {
          const spanElement = document.createElement("span");
          spanElement.textContent = "...";
          const prependElem = spanElement.cloneNode(true);
          prependElem.classList.add("dots");

          const lastButtonElement = document.createElement("button");
          const firstButtonElement = document.createElement("button");

          lastButtonElement.classList.add("js-page", "page", "last-page");
          lastButtonElement.setAttribute("page", this.pageNumbers.length);
          lastButtonElement.textContent = this.pageNumbers.length;

          firstButtonElement.classList.add("js-page", "page", "first-page");
          firstButtonElement.setAttribute("page", 1);
          firstButtonElement.textContent = 1;

          this.pageNumbersContainer.appendChild(spanElement);
          this.pageNumbersContainer.prepend(prependElem);
          this.pageNumbersContainer.prepend(firstButtonElement);
          this.pageNumbersContainer.appendChild(lastButtonElement);

          if (this.currentPage < 5) {
            prependElem.classList.add("hidden");
            firstButtonElement.classList.add("hidden");
          } else {
            prependElem.classList.remove("hidden");
            firstButtonElement.classList.remove("hidden");
          }

          if (
            this.currentPage >= this.pageNumbers.length - 5 &&
            this.currentPage != 1
          ) {
            spanElement.classList.add("hidden");
            lastButtonElement.classList.add("hidden");
          }
        } else {
          if (this.currentPage >= this.pageNumbers.length - 5) {
            lastBtn.classList.add("hidden");
            lastSpan.classList.add("hidden");

            if (this.currentPage < 5) {
              prepend.classList.add("hidden");
              firstBtn.classList.add("hidden");
            } else {
              prepend.classList.remove("hidden");
              firstBtn.classList.remove("hidden");
            }

            if (this.pageNumbers[1].classList.contains("hidden")) {
              prepend.classList.remove("hidden");
              firstBtn.classList.remove("hidden");
            }
          } else {
            lastBtn.classList.remove("hidden");
            lastSpan.classList.remove("hidden");
            prepend.classList.add("hidden");
            firstBtn.classList.add("hidden");

            if (this.currentPage >= 5) {
              prepend.classList.remove("hidden");
              firstBtn.classList.remove("hidden");
            }
          }
        }
      }
    } catch {}
  }
  /**
   * This method executes an automatic scroll to the top of the element
   */
  scrollTop() {
    if (!this.latestNews) {
      window.scrollTo({
        top:
          this.module.offsetTop / 2.5 -
          document.querySelector("header").clientHeight,
        behavior: "smooth",
      });
    } else {
      window.scrollTo({
        top:
         this.postsContainer.getBoundingClientRect().top + window.scrollY - document.querySelector(".js-navbar").clientHeight - 100,
        behavior: "smooth",
      });
    }
  }
  /**
   * This method builds the url based on the selected filters
   * and the value of the search input
   */
  setUrl() {
    // Pagination
    const pagePost = [
      {
        name: "page",
        value: this.currentPage,
      },
    ];

    // Filters
    this.currentFilters.forEach((filter) => {
      if (filter.term != "all") {
        pagePost.push({
          name: filter.taxonomy,
          value: filter.term,
        });
      }
    });

    // Search
    if (this.searchValue != "") {
      pagePost.push({
        name: "s",
        value: this.searchValue,
      });
    } else {
      pagePost.push({
        name: "s",
        value: "",
      });
    }

    let fullArgs = "";
    pagePost.forEach((args, key) => {
      fullArgs +=
        key == pagePost.length - 1
          ? `${args.name}=${args.value}`
          : `${args.name}=${args.value}&`;
    });

    // Add args
    window.history.pushState("", "", `?${fullArgs}`);
  }
  /**
   * This method adds an animated loader with its styles
   */
  loader() {
    this.postsContainer.classList.add("loading");
    this.postsContainer.innerHTML =
      '<div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>';
    if (!document.querySelector("#loader-ajax-posts")) {
      const style = document.createElement("style");
      style.setAttribute("id", "loader-ajax-posts");
      style.textContent = `
            .lds-roller {
                display: block;
                position: relative;
                width: 80px;
                height: 80px;
                margin: 50px auto;
              }
              .lds-roller div {
                animation: lds-roller 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
                transform-origin: 40px 40px;
                
              }
              .lds-roller div:after {
                content: " ";
                display: block;
                position: absolute;
                width: 7px;
                height: 7px;
                border-radius: 50%;
                background-color: ${this.loaderColor};
                margin: -4px 0 0 -4px;
              }
              .lds-roller div:nth-child(1) {
                animation-delay: -0.036s;
              }
              .lds-roller div:nth-child(1):after {
                top: 63px;
                left: 63px;
              }
              .lds-roller div:nth-child(2) {
                animation-delay: -0.072s;
              }
              .lds-roller div:nth-child(2):after {
                top: 68px;
                left: 56px;
              }
              .lds-roller div:nth-child(3) {
                animation-delay: -0.108s;
              }
              .lds-roller div:nth-child(3):after {
                top: 71px;
                left: 48px;
              }
              .lds-roller div:nth-child(4) {
                animation-delay: -0.144s;
              }
              .lds-roller div:nth-child(4):after {
                top: 72px;
                left: 40px;
              }
              .lds-roller div:nth-child(5) {
                animation-delay: -0.18s;
              }
              .lds-roller div:nth-child(5):after {
                top: 71px;
                left: 32px;
              }
              .lds-roller div:nth-child(6) {
                animation-delay: -0.216s;
              }
              .lds-roller div:nth-child(6):after {
                top: 68px;
                left: 24px;
              }
              .lds-roller div:nth-child(7) {
                animation-delay: -0.252s;
              }
              .lds-roller div:nth-child(7):after {
                top: 63px;
                left: 17px;
              }
              .lds-roller div:nth-child(8) {
                animation-delay: -0.288s;
              }
              .lds-roller div:nth-child(8):after {
                top: 56px;
                left: 12px;
              }
              @keyframes lds-roller {
                0% {
                  transform: rotate(0deg);
                }
                100% {
                  transform: rotate(360deg);
                }
              }
            `;
      document.head.append(style);
    }
  }
  /**
   * This method handles the taxonomy filters behavior and
   * executes the call method with the selected filter
   */
  filters() {
    const self = this;

    this.taxonomiesBoxes.forEach((taxonomy) => {
      const current = taxonomy.querySelector(".js-current-taxonomy");
      const taxonomyTerms = taxonomy.querySelectorAll(".js-taxonomy-option");
      const dropdown = current.parentElement.querySelector(
        ".js-taxonomies-options"
      );
      const currentTax = dropdown.querySelector(
        ".js-taxonomy-option:first-child"
      );
      const currentHeight = current.getBoundingClientRect().height;
      const optionsHeight = dropdown.getBoundingClientRect().height + 12;

      taxonomy.style.height = `${currentHeight}px`;

      currentTax.classList.add("active");

      this.currentFilters.push({
        taxonomy: taxonomy.getAttribute("taxonomy"),
        term: "all",
      });

      let open = false;
      const postsPadding = this.postsContainer.style.paddingTop;

      current.addEventListener("click", () => {
        open = !open;
        dropdown.classList.toggle("hidden-filters");
        taxonomy.style.height = dropdown.classList.contains("hidden-filters")
          ? `${currentHeight}px`
          : `${currentHeight + optionsHeight}px`;

        if (!this.latestNews) {
          if (window.innerWidth > 768) {
            const filtersHeight = dropdown.getBoundingClientRect().height;
            if (filtersHeight > 28 && open) {
              this.postsContainer.style.paddingTop = `${filtersHeight + 55}px`;
            } else if (!open) {
              setTimeout(() => {
                this.postsContainer.style.paddingTop = postsPadding;
              }, 300);
            }
          }
        }
      });

      taxonomyTerms.forEach((term) => {
        term.addEventListener("click", () => {
          const active = term.parentNode.querySelector(".active");

          if (active) {
            active.classList.remove("active");
          }

          term.classList.add("active");

          // Change current filter
          self.currentFilters.filter(
            (filter) => filter.taxonomy == term.getAttribute("taxonomy")
          )[0].term = term.getAttribute("term");
          self.currentPage = 1;
          self.call(true);
        });
      });
    });
  }
  /**
   * This method adds the functionality to the search input.
   * See the Debounce class for further details
   * Note that an api request is done through the doneFunction.
   */
  searchPosts() {
    console.log('search posts');
    if (this.searchInput) {
      new Debounce({
        input: this.searchInput,
        time: 300,
        doneFunction: (value) => {
          this.searchValue = value;
          this.currentPage = 1;
          this.call(true);
        },
      });
    } else {
      this.call();
    }
  }
  /**
   * This method will set the controllers based on the api response
   * @param {boolean} reloadController
   * @param {object} response
   */
  refreshController(reloadController, response) {
    try {
      if (reloadController) {
        if (response.data.controllers) {
          this.controllers.innerHTML = response.data.controllers;
        } else {
          this.controllers.innerHTML = "";
        }

        this.pages = parseInt(response.data.pages);
        this.postsContainer.setAttribute("page", "1");
        this.currentPage = 1;

        if (this.setupControllerVars()) {
          this.arrowsClick();
          this.pageNumbersLimiter();
          this.pageNumbersClick();
        }
      }
    } catch {}
  }
  /**
   * This method executes a "get request" to the following endpoint:
   * /post-powers/v1/paged-posts
   * Hint: Some params object properties will be the ones you set
   * when you use the AdvancedPagination::print method from
   * advanced-pagination.php file
   * Note that inside of this method other methods are called too,
   * refer to them if you don't recall what they do
   * @param {boolean} reloadController
   */
  call(reloadController = false) {
    console.log('call');
    this.postsContainer.style.height = `${this.postsContainer.clientHeight}px`;
    this.setUrl();
    this.loader();
    this.pageNumbersLimiter();
    this.pageNumbersClick();


    Api.get("post-powers/v1/paged-posts", {
      params: {
        post_type: this.postType,
        page: this.currentPage,
        posts_per_page: this.postsPerPage,
        component: this.component,
        component_parent: this.componentParent,
        filters: this.currentFilters,
        search: this.searchValue,
        next_controller_button: this.paginator.getAttribute("next"),
        prev_controller_button: this.paginator.getAttribute("prev"),
        controller_limit_button: this.paginator.getAttribute("limit"),
        no_results_message: this.nothingFoundMessage,
      },
    })
      .then((response) => {
        this.postsContainer.classList.remove("loading");
        // ScrollTrigger.refresh();
        // this.scrollTop();
        if (response.data.status) {
          this.postsContainer.innerHTML = response.data.posts;
          this.postsContainer.classList.remove("nothing-found");
        } else {
          this.postsContainer.innerHTML = response.data.message;
          this.postsContainer.classList.add("nothing-found");
        }
        this.refreshController(reloadController, response);
        this.postsContainer.style.height = "max-content";
      })
      .catch((error) => {
        this.postsContainer.innerHTML = "Opss! Something went wrong...";
        console.error(error);
      });
  }
}

export default AdvancedPagination;
