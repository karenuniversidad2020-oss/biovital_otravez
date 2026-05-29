import { promises as fs } from 'node:fs';
import path from 'node:path';
import sharp from 'sharp';

const projectRoot = process.cwd();
const candidateAssetDirs = [
  'public',
  'static',
  'src/assets',
  'assets',
  'images',
  'img',
];

const imageExtensions = new Set(['.png', '.jpg', '.jpeg']);
const ignoredSegments = new Set(['node_modules', '.git']);

function formatBytes(bytes) {
  return `${(bytes / 1024).toFixed(2)} KB`;
}

function percentSaved(before, after) {
  if (!before) return '0.00%';
  return `${(((before - after) / before) * 100).toFixed(2)}%`;
}

async function exists(targetPath) {
  try {
    await fs.access(targetPath);
    return true;
  } catch {
    return false;
  }
}

function shouldIgnore(targetPath) {
  const parts = path.relative(projectRoot, targetPath).split(path.sep);
  return parts.some((part) => ignoredSegments.has(part));
}

async function collectImages(directory) {
  const images = [];
  const entries = await fs.readdir(directory, { withFileTypes: true });

  for (const entry of entries) {
    const fullPath = path.join(directory, entry.name);

    if (shouldIgnore(fullPath)) continue;

    if (entry.isDirectory()) {
      images.push(...await collectImages(fullPath));
      continue;
    }

    if (!entry.isFile()) continue;

    const extension = path.extname(entry.name).toLowerCase();
    if (imageExtensions.has(extension)) {
      images.push(fullPath);
    }
  }

  return images;
}

async function getAssetDirectories() {
  const directories = [];

  for (const relativeDir of candidateAssetDirs) {
    const absoluteDir = path.join(projectRoot, relativeDir);
    if (await exists(absoluteDir)) {
      directories.push(absoluteDir);
    }
  }

  return directories;
}

async function optimizeImage(filePath) {
  const extension = path.extname(filePath).toLowerCase();
  const originalBuffer = await fs.readFile(filePath);
  const originalSize = originalBuffer.length;

  let optimizedBuffer;

  if (extension === '.png') {
    optimizedBuffer = await sharp(originalBuffer)
      .png({
        quality: 85,
        effort: 9,
        compressionLevel: 9,
        palette: true,
      })
      .toBuffer();
  } else if (extension === '.jpg' || extension === '.jpeg') {
    optimizedBuffer = await sharp(originalBuffer)
      .jpeg({
        quality: 82,
        mozjpeg: true,
        progressive: true,
      })
      .toBuffer();
  } else {
    return { skipped: true, originalSize, optimizedSize: originalSize, saved: 0 };
  }

  const optimizedSize = optimizedBuffer.length;

  if (optimizedSize < originalSize) {
    await fs.writeFile(filePath, optimizedBuffer);
    return {
      skipped: false,
      written: true,
      originalSize,
      optimizedSize,
      saved: originalSize - optimizedSize,
    };
  }

  return {
    skipped: false,
    written: false,
    originalSize,
    optimizedSize: originalSize,
    saved: 0,
  };
}

async function main() {
  const assetDirectories = await getAssetDirectories();

  if (assetDirectories.length === 0) {
    console.log('No se encontraron directorios de assets para optimizar.');
    return;
  }

  console.log('Directorios analizados:');
  for (const directory of assetDirectories) {
    console.log(`- ${path.relative(projectRoot, directory) || '.'}`);
  }
  console.log('');

  const imagePaths = [];
  for (const directory of assetDirectories) {
    imagePaths.push(...await collectImages(directory));
  }

  const uniqueImagePaths = [...new Set(imagePaths)].sort((a, b) => a.localeCompare(b));

  if (uniqueImagePaths.length === 0) {
    console.log('No se encontraron imágenes PNG/JPG/JPEG para optimizar.');
    return;
  }

  let totalBefore = 0;
  let totalAfter = 0;
  let totalSaved = 0;
  let optimizedCount = 0;

  for (const filePath of uniqueImagePaths) {
    const result = await optimizeImage(filePath);
    const relativePath = path.relative(projectRoot, filePath);

    totalBefore += result.originalSize;
    totalAfter += result.optimizedSize;
    totalSaved += result.saved;

    if (result.written) optimizedCount += 1;

    const status = result.written ? 'optimizada' : 'sin cambios';
    console.log(
      `${relativePath} | ${formatBytes(result.originalSize)} -> ${formatBytes(result.optimizedSize)} | ahorro ${formatBytes(result.saved)} (${percentSaved(result.originalSize, result.optimizedSize)}) | ${status}`
    );
  }

  console.log('');
  console.log('Resumen global:');
  console.log(`- Imágenes procesadas: ${uniqueImagePaths.length}`);
  console.log(`- Imágenes sobrescritas: ${optimizedCount}`);
  console.log(`- Tamaño antes: ${formatBytes(totalBefore)}`);
  console.log(`- Tamaño después: ${formatBytes(totalAfter)}`);
  console.log(`- Ahorro total: ${formatBytes(totalSaved)} (${percentSaved(totalBefore, totalAfter)})`);
}

main().catch((error) => {
  console.error('Error optimizando imágenes:', error);
  process.exitCode = 1;
});
