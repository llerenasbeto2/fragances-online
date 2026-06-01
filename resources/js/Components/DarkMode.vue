<template>
  <label class="switch">
    <input
      id="input"
      type="checkbox"
      @change="handleThemeSwitch"
    />

    <div class="slider round">
      <div class="sun-moon">
        <svg id="moon-dot-1" class="moon-dot" viewBox="0 0 100 100">
          <circle cx="50" cy="50" r="50" />
        </svg>

        <svg id="moon-dot-2" class="moon-dot" viewBox="0 0 100 100">
          <circle cx="50" cy="50" r="50" />
        </svg>

        <svg id="moon-dot-3" class="moon-dot" viewBox="0 0 100 100">
          <circle cx="50" cy="50" r="50" />
        </svg>

        <svg id="light-ray-1" class="light-ray" viewBox="0 0 100 100">
          <circle cx="50" cy="50" r="50" />
        </svg>

        <svg id="light-ray-2" class="light-ray" viewBox="0 0 100 100">
          <circle cx="50" cy="50" r="50" />
        </svg>

        <svg id="light-ray-3" class="light-ray" viewBox="0 0 100 100">
          <circle cx="50" cy="50" r="50" />
        </svg>

        <svg id="cloud-1" class="cloud-dark" viewBox="0 0 100 100">
          <circle cx="50" cy="50" r="50" />
        </svg>

        <svg id="cloud-2" class="cloud-dark" viewBox="0 0 100 100">
          <circle cx="50" cy="50" r="50" />
        </svg>

        <svg id="cloud-3" class="cloud-dark" viewBox="0 0 100 100">
          <circle cx="50" cy="50" r="50" />
        </svg>

        <svg id="cloud-4" class="cloud-light" viewBox="0 0 100 100">
          <circle cx="50" cy="50" r="50" />
        </svg>

        <svg id="cloud-5" class="cloud-light" viewBox="0 0 100 100">
          <circle cx="50" cy="50" r="50" />
        </svg>

        <svg id="cloud-6" class="cloud-light" viewBox="0 0 100 100">
          <circle cx="50" cy="50" r="50" />
        </svg>
      </div>

      <div class="stars">
        <svg id="star-1" class="star" viewBox="0 0 20 20">
          <path
            d="M 0 10 C 10 10,10 10 ,0 10 C 10 10 , 10 10 , 10 20 C 10 10 , 10 10 , 20 10 C 10 10 , 10 10 , 10 0 C 10 10,10 10 ,0 10 Z"
          />
        </svg>

        <svg id="star-2" class="star" viewBox="0 0 20 20">
          <path
            d="M 0 10 C 10 10,10 10 ,0 10 C 10 10 , 10 10 , 10 20 C 10 10 , 10 10 , 20 10 C 10 10 , 10 10 , 10 0 C 10 10,10 10 ,0 10 Z"
          />
        </svg>

        <svg id="star-3" class="star" viewBox="0 0 20 20">
          <path
            d="M 0 10 C 10 10,10 10 ,0 10 C 10 10 , 10 10 , 10 20 C 10 10 , 10 10 , 20 10 C 10 10 , 10 10 , 10 0 C 10 10,10 10 ,0 10 Z"
          />
        </svg>

        <svg id="star-4" class="star" viewBox="0 0 20 20">
          <path
            d="M 0 10 C 10 10,10 10 ,0 10 C 10 10 , 10 10 , 10 20 C 10 10 , 10 10 , 20 10 C 10 10 , 10 10 , 10 0 C 10 10,10 10 ,0 10 Z"
          />
        </svg>
      </div>
    </div>
  </label>
</template>

<script>
import { switchTheme } from '@/theme.js'

export default {
  name: 'Darkmode',
  methods: {
    handleThemeSwitch() {
      switchTheme()
    }
  }
}
</script>

<style scoped>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch #input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  inset: 0;
  background-color: #2196f3;
  transition: 0.4s;
  z-index: 0;
  overflow: hidden;
}

.sun-moon {
  position: absolute;
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: yellow;
  transition: 0.4s;
}

#input:checked + .slider {
  background-color: #000;
}

#input:focus + .slider {
  box-shadow: 0 0 1px #2196f3;
}

#input:checked + .slider .sun-moon {
  transform: translateX(26px);
  background-color: #fff;
  animation: rotate-center 0.6s ease-in-out both;
}

@keyframes rotate-center {
  0% {
    transform: translateX(26px) rotate(0);
  }
  100% {
    transform: translateX(26px) rotate(180deg);
  }
}

.moon-dot {
  opacity: 0;
  transition: 0.4s;
  fill: gray;
}

#input:checked + .slider .sun-moon .moon-dot {
  opacity: 1;
}

.slider.round {
  border-radius: 34px;
}

.slider.round .sun-moon {
  border-radius: 50%;
}

#moon-dot-1 {
  left: 10px;
  top: 3px;
  position: absolute;
  width: 6px;
  height: 6px;
}

#moon-dot-2 {
  left: 2px;
  top: 10px;
  position: absolute;
  width: 10px;
  height: 10px;
}

#moon-dot-3 {
  left: 16px;
  top: 18px;
  position: absolute;
  width: 3px;
  height: 3px;
}

#light-ray-1 {
  left: -8px;
  top: -8px;
  position: absolute;
  width: 43px;
  height: 43px;
  fill: white;
  opacity: 0.1;
  z-index: -1;
}

#light-ray-2 {
  left: -50%;
  top: -50%;
  position: absolute;
  width: 55px;
  height: 55px;
  fill: white;
  opacity: 0.1;
  z-index: -1;
}

#light-ray-3 {
  left: -18px;
  top: -18px;
  position: absolute;
  width: 60px;
  height: 60px;
  fill: white;
  opacity: 0.1;
  z-index: -1;
}

.cloud-light,
.cloud-dark {
  position: absolute;
  animation: cloud-move 6s infinite;
}

.cloud-light {
  fill: #eee;
}

.cloud-dark {
  fill: #ccc;
  animation-delay: 1s;
}

#cloud-1 {
  left: 30px;
  top: 15px;
  width: 40px;
}

#cloud-2 {
  left: 44px;
  top: 10px;
  width: 20px;
}

#cloud-3 {
  left: 18px;
  top: 24px;
  width: 30px;
}

#cloud-4 {
  left: 36px;
  top: 18px;
  width: 40px;
}

#cloud-5 {
  left: 48px;
  top: 14px;
  width: 20px;
}

#cloud-6 {
  left: 22px;
  top: 26px;
  width: 30px;
}

@keyframes cloud-move {
  0% {
    transform: translateX(0);
  }
  40% {
    transform: translateX(4px);
  }
  80% {
    transform: translateX(-4px);
  }
  100% {
    transform: translateX(0);
  }
}

.stars {
  transform: translateY(-32px);
  opacity: 0;
  transition: 0.4s;
}

.star {
  fill: white;
  position: absolute;
  animation: star-twinkle 2s infinite;
}

#input:checked + .slider .stars {
  transform: translateY(0);
  opacity: 1;
}

#star-1 {
  width: 20px;
  top: 2px;
  left: 3px;
  animation-delay: 0.3s;
}

#star-2 {
  width: 6px;
  top: 16px;
  left: 3px;
}

#star-3 {
  width: 12px;
  top: 20px;
  left: 10px;
  animation-delay: 0.6s;
}

#star-4 {
  width: 18px;
  top: 0;
  left: 18px;
  animation-delay: 1.3s;
}

@keyframes star-twinkle {
  0% {
    transform: scale(1);
  }
  40% {
    transform: scale(1.2);
  }
  80% {
    transform: scale(0.8);
  }
  100% {
    transform: scale(1);
  }
}
</style>
