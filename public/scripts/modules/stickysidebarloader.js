
//import StickySidebar from "sticky-sidebar-v2"

export class StickySidebarLoader {
  StickySidebar = null;
	constructor(){
    this.loadStickySidebar();
  }
  async loadStickySidebar() {
    try {
      const sd = await import("sticky-sidebar-v2");
      this.StickySidebar = sd.default;
      this.initStickySidebar();
    } catch (error) {
      console.error("Error loading StickySidebar", error);
    }
  }
  initStickySidebar() {
    console.log("StickySidebar", this.StickySidebar );
    if( document.querySelector( "nav.nav-section" ) && typeof StickySidebar !== "undefined" ) {
      if( document.querySelector( ".body__sticky-container" ) ) {
        new this.StickySidebar( ".nav-section", {
          topSpacing: 10,
          bottomSpacing: 10,
          containerSelector: ".body__sticky-container",
          innerWrapperSelector: "#sidebar_menu",
          minWidth: 767,
        } );
      }
    }
  }
}