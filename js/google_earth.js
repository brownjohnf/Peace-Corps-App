// JavaScript Document
google.load("earth", "1");
		function init() {
			google.earth.createInstance('ws_map', initCB, failureCB);
		}
		function initCB(instance) {
			ge = instance;
			ge.getWindow().setVisibility(true);
		
			var link = ge.createLink('');
			var href = 'http://pcsenegal.org/water_sanitation/water_sanitation_projects.kml'
			link.setHref(href);

			var networkLink = ge.createNetworkLink('');
			networkLink.set(link, true, true); // Sets the link, refreshVisibility, and flyToView
			ge.getFeatures().appendChild(networkLink);
		}
		function failureCB(errorCode) {
		}
		google.setOnLoadCallback(init);