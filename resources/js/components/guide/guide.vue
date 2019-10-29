<template>
    <div>
        <section class="hero is-medium is-info is-bold">
            <div class="hero-body">
                <div class="container has-text-centered">
                    <h1 class="title">
                        使用指南
                    </h1>
                    <h2 class="subtitle">
                        引导你使用 Work 解决繁琐的『政治任务』
                    </h2>
                </div>
            </div>
        </section>
        <div class="container content">
            <section class="section">
                <p>简易指引：</p>
                <ol>
                    <li>在首页的输入框输入你的任务名称</li>
                    <li>将跳转到的页面链接分享给你的同学</li>
                    <li>在统计页面可以观察到收集进度，可以在此导出压缩包</li>
                </ol>

                <p>数据在服务器上留存 14 日，超期自动清理。</p>
            </section>
            <section class="section">
                <p>编写 Work 的初衷，是希望通过代码来解决繁琐的、重复性的政治任务：收集青年大学习截图。</p>
                <p>在缺乏工具的蛮荒时代，解决这项工作至少需要消耗一个智商在线的劳动力为核心，数个劳动力作为辅助，而合格劳动力的匮乏以及长期枯燥无趣的工作到基层是难以下派的。在经过近一个学期的枯燥工作后，经过合理的分析让我逐步意识到这是一项长期工作。</p>
                <p>2019 年 1 月 20 日，我为 Work 项目第一次提交代码，它在最初被设计成一个足够简易的、满足自身需要的工具。经过长达半年的验证与更新，Work 也能满足其他活动的截图收集，Work 的生产版本已经收集了超过 1000 个表单，100000 张图片，以及一次性能瓶颈优化、数据重置。但逐渐的，项目的使用用户逐渐增多，项目庞大的图片数据已经成了服务器的拖累，截至目前服务器已经存储了 10G 图片，而这些图片通常无需留存，但却成为了服务器的主要成本，但我无法将这些数据肆意删除。</p>
                <div class="has-text-centered">
                    <p>你可以出于自愿的向项目资助 <strong>￥1 / 次</strong> 或 <strong>￥9.9 / 月</strong>，以便项目可持续的运营</p>

                    <img alt="给我打钱" src="../../../../storage/app/image/wechat_qrcode.png" />
                </div>
            </section>
        </div>
    </div>
</template>
<style scoped>
    ol, p {
        font-size: 1.2rem;
    }
</style>
