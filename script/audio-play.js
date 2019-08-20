(function() {

let audioElementList = document.querySelectorAll(".audio-control ~ audio");
let continuePlaying = false;
audioElementList.forEach(setUpPlayer);

function setUpPlayer(audio) {
	let button = document.createElement("button");
	let placeholder = audio.previousElementSibling;
	button.innerHTML = placeholder.innerHTML;

	audio.hidden = true;
	placeholder.replaceWith(button);

	audio.impostorControlButton = button;
	audio.addEventListener("play", play);
	audio.addEventListener("pause", pause);

	button.addEventListener("click", function(e) {
		e.preventDefault();
		continuePlaying = false;

		if(button.classList.contains("playing")) {
			stopAudio(audio);
		}
		else {
			startAudio(audio);
		}
	});

	document.querySelectorAll(".play-all").forEach(function(playAllButton) {
		playAllButton.addEventListener("click", playAll);
	});
}

function play(e) {
	stopAllAudio(this);
	this.impostorControlButton.classList.add("playing");
}

function pause(e) {
	this.impostorControlButton.classList.remove("playing");

	if(!continuePlaying) {
		return;
	}

	let parentLi = this.closest("li");
	let questionDiv = this.closest(".question");

	if(questionDiv) {
		let answerAudio = parentLi.querySelector(".answer audio");
		if(!answerAudio) {
			return;
		}

		startAudio(answerAudio);
	}
	else {
		let nextLi = parentLi.nextElementSibling;

		if(!nextLi) {
			return;
		}

		startAudio(nextLi.querySelector("audio"));
	}
}

function startAudio(audio) {
	audio.currentTime = 0;
	audio.play();
}

function stopAudio(audio) {
	audio.pause();
	audio.currentTime = 0;
}

function stopAllAudio(apartFrom) {
	document.querySelectorAll("audio").forEach(function(audio) {
		if(audio === apartFrom) {
			return;
		}

		stopAudio(audio);
	});
}

function playAll() {
	let currentPlaying = document.querySelector("button.playing");
	if(currentPlaying) {
		continuePlaying = false;
		stopAllAudio();
	}
	else {
		continuePlaying = true;

		startAudio(
			document.querySelector("audio")
		);
	}
}

})();