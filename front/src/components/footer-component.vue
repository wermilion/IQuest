<script setup lang="ts">
import { ref } from "vue";

const linksSocial = ref([
  {
    heref: "https://vk.com/iquest",
    img: "vk.svg",
  },
  {
    heref: "https://t.me/questtomsk",
    img: "telegram.svg",
  },
  {
    heref:
      "https://www.youtube.com/channel/UCiEXe3D9fy8GX9X73lpxOxA?disable_polymer=true",
    img: "youtube.svg",
  },
]);

const contacts = ref([
  {
    text: "94-29-10",
    img: "phone.svg",
  },
  {
    text: "iquest.tsk@gmail.com",
    img: "mail.svg",
  },
]);
</script>

<template>
  <div class="baground-black">
    <div class="container footer">
      <img src="/logo/logo_full.svg" alt="logo" />
      <div class="footer-links">
        <div class="footer-links__contacts">
          <span class="body" v-for="info in contacts">
            <img :src="`/icons/${info.img}`" :alt="info.img" /> {{ info.text }}
          </span>
        </div>
        <div class="footer-links__social">
          <a v-for="link in linksSocial" :href="link.heref">
            <img :src="`/icons/social/${link.img}`" :alt="link.img" />
          </a>
        </div>
      </div>
      <div class="footer-privacy">
        <p class="smallFootnote">Политика конфиденциальности</p>
        <span class="smallFootnote">
          Разработано в <img src="/logo/asapLogo.svg" alt="asapLogo" />
        </span>
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss">
.baground-black {
  background-color: $color-black;
}

.footer {
  height: 100%;
  margin-inline: auto;
  padding: 72px 88px;
  justify-content: space-between;
  max-height: 282px;

  &-links {
    display: flex;
    flex-direction: column;
    justify-content: space-between;

    &__contacts {
      display: flex;
      flex-direction: column;
      gap: 12px;

      span {
        display: flex;
        gap: 8px;
        color: $color-white;
      }
    }

    &__social {
      display: flex;
      gap: 16px;
      align-items: flex-start;
    }
  }

  &-privacy {
    justify-content: space-between;
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    color: $color-white;

    span {
      display: flex;
      align-items: center;
      gap: 8px;
    }
  }
}
</style>
