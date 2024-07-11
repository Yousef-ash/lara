const errorLabel = document.querySelector("label[for='error-msg']");
const latInp = document.querySelector("#latitude");
const lonInp = document.querySelector("#longitude");
const airQuality = document.querySelector(".air-quality");
const airQualityStatus = document.querySelector(".air-quality-status");
const srchBtn = document.querySelector(".search-btn");
const componentsEle = document.querySelectorAll(".component-val");
const adviceText = document.querySelector(".advice-text");
const temperatureEle = document.querySelector(".temperature");
const humidityEle = document.querySelector(".humidity");

const appId = "f8fb854aa22a719897ee54bc095e1700"; // OpenWeatherMap API Key
const airQualityLink = "https://api.openweathermap.org/data/2.5/air_pollution";
const weatherLink = "https://api.openweathermap.org/data/2.5/weather";
const geocodeKey = "8fac9ba1ca264d438e2ed7c17e74146a";
const geocodeLink = `https://api.opencagedata.com/geocode/v1/json?key=${geocodeKey}`;

const getUserLocation = () => {
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(
			onPositionGathered,
			onPositionGatherError
		);
	} else {
		onPositionGatherError({
			message: "Can't access your location. Please enter your coordinates.",
		});
	}
};

const onPositionGathered = (pos) => {
	let lat = pos.coords.latitude.toFixed(4),
		lon = pos.coords.longitude.toFixed(4);

	latInp.value = lat;
	lonInp.value = lon;

	fetchData(lat, lon);
};

const onPositionGatherError = (e) => {
	errorLabel.innerText = e.message;
};

const fetchData = async (lat, lon) => {
	try {
		const airQualityFetch = await fetch(
			`${airQualityLink}?lat=${lat}&lon=${lon}&appid=${appId}`
		);
		if (!airQualityFetch.ok) {
			throw new Error('Failed to fetch air quality data');
		}
		const airQualityData = await airQualityFetch.json();
		setValuesOfAir(airQualityData);

		const weatherFetch = await fetch(
			`${weatherLink}?lat=${lat}&lon=${lon}&appid=${appId}&units=metric`
		);
		if (!weatherFetch.ok) {
			throw new Error('Failed to fetch weather data');
		}
		const weatherData = await weatherFetch.json();
		setValuesOfWeather(weatherData);
	} catch (error) {
		console.error("Error fetching data:", error);
		errorLabel.innerText = error.message;
	}
};

const setValuesOfAir = (data) => {
	const aqi = data.list[0].main.aqi;
	let airStat = "",
		color = "";

	airQuality.innerText = aqi;

	switch (aqi) {
		case 1:
			airStat = "Good";
			color = "rgb(19, 201, 28)";
			break;
		case 2:
			airStat = "Fair";
			color = "rgb(15, 134, 25)";
			break;
		case 3:
			airStat = "Moderate";
			color = "rgb(201, 204, 13)";
			break;
		case 4:
			airStat = "Poor";
			color = "rgb(204, 83, 13)";
			break;
		case 5:
			airStat = "Very Poor";
			color = "rgb(204, 13, 13)";
			break;
		default:
			airStat = "Unknown";
	}

	airQualityStatus.innerText = airStat;
	airQualityStatus.style.color = color;

	componentsEle.forEach((ele) => {
		const attr = ele.getAttribute("data-comp");
		ele.innerText = data.list[0].components[attr] + " μg/m³";
	});

	updateChart(aqi);
	provideHealthAdvice(aqi);
};

const setValuesOfWeather = (data) => {
	let temp = data.main.temp;
	let humidity = data.main.humidity;

	temperatureEle.innerText = `Temperature: ${temp} °C`;
	humidityEle.innerText = `Humidity: ${humidity} %`;
};

const updateChart = (aqi) => {
	if (window.aqiChart instanceof Chart) {
		window.aqiChart.destroy();
	}

	const ctx = document.getElementById("aqiChart").getContext("2d");
	window.aqiChart = new Chart(ctx, {
		type: "line",
		data: {
			labels: ["1", "2", "3", "4", "5"],
			datasets: [
				{
					label: "Air Quality Index",
					data: [aqi, aqi, aqi, aqi, aqi],
					backgroundColor: "rgba(255, 99, 132, 0.2)",
					borderColor: "rgba(255, 99, 132, 1)",
					borderWidth: 1,
				},
			],
		},
		options: {
			scales: {
				y: {
					beginAtZero: true,
				},
			},
		},
	});
};

const provideHealthAdvice = (aqi) => {
	let advice = "";
	switch (aqi) {
		case 1:
			advice = "Air quality is considered satisfactory, and air pollution poses little or no risk.";
			break;
		case 2:
			advice =
				"Air quality is acceptable; however, some pollutants may be a concern for a very small number of people who are unusually sensitive to air pollution.";
			break;
		case 3:
			advice =
				"Members of sensitive groups may experience health effects. The general public is not likely to be affected.";
			break;
		case 4:
			advice =
				"Everyone may begin to experience health effects; members of sensitive groups may experience more serious health effects.";
			break;
		case 5:
			advice =
				"Health alert: everyone may experience more serious health effects.";
			break;
		default:
			advice = "No advice available.";
	}
	adviceText.innerText = advice;
};

srchBtn.addEventListener("click", async () => {
	try {
		const geoResponse = await fetch(`${geocodeLink}&q=${encodeURIComponent('current')}`);
		if (!geoResponse.ok) {
			throw new Error('Failed to fetch geolocation data');
		}
		const geoData = await geoResponse.json();
		console.log("Geocoding API response:", geoData); // For debugging purposes

		if (geoData.results.length > 0) {
			const lat = geoData.results[0].geometry.lat.toFixed(4);
			const lon = geoData.results[0].geometry.lng.toFixed(4);
			latInp.value = lat;
			lonInp.value = lon;
			fetchData(lat, lon);
		} else {
			throw new Error("No results found for the current location.");
		}
	} catch (error) {
		console.error("Error fetching geolocation data:", error);
		errorLabel.innerText = error.message;
	}
});

getUserLocation();
