(function() {
let audioInput = document.querySelector(".audio-recorder input");
if(!audioInput) {
	return;
}

function setUpMedia(stream) {
	audioInput.hidden = true;
	const submitButton = document.querySelector("[name=do]");
	const button = document.createElement("button");
	const RECORDING_LENGTH = 12;
	const options = {mimeType: 'audio/webm'};
	const recordedChunks = [];
	const mediaRecorder = new MediaRecorder(stream, options);
	let recTimeout = null;
	let file = null;

	button.innerText = "Record";
	audioInput.after(button);

	audioInput.form.addEventListener("submit", function(e) {
		e.preventDefault();
		let askAnswer = submitButton.value;

		let url = this.getAttribute("action")
			|| window.location.href;
		let formData = new FormData(this);
		formData.set("audio", file);
		formData.set("do", askAnswer);

		fetch(url, {
			credentials: "include",
			redirect: "follow",
			method: "POST",
			body: formData,
		}).then(function(response) {
			if(response.ok) {
				window.location.href = response.url;
			}
		});
	});

	mediaRecorder.addEventListener("dataavailable", function(e) {
		if (e.data.size > 0) {
			recordedChunks.push(e.data);
		}
	});

	mediaRecorder.addEventListener("stop", function() {
		let blob = new Blob(recordedChunks, {type: options.mimeType});
		button.innerText = button.dataset.originalText;
		delete button.dataset.originalText;
		delete button.dataset.recording;
		clearTimeout(recTimeout);
		recTimeout = null;
		submitButton.disabled = false;

		file = new File([blob], "example.webm");
	});

	button.addEventListener("click", function(e) {
		e.preventDefault();
		submitButton.disabled = true;

		if(this.dataset.recording) {
			mediaRecorder.stop();
		}
		else {
			this.dataset.originalText = this.innerText;
			this.dataset.recording = RECORDING_LENGTH.toString();
			mediaRecorder.start();
			updateRecButton();
		}

		function updateRecButton() {
			button.innerText = button.dataset.recording;
			button.dataset.recording--;
			if(button.dataset.recording >= 0) {
				recTimeout = setTimeout(
					updateRecButton,
					1000
				);
			}
			else {
				mediaRecorder.stop();
			}
		}
	});
}

navigator.mediaDevices.getUserMedia({ audio: true, video: false })
	.then(setUpMedia);
})();
