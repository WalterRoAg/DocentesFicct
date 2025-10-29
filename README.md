# DocentesFicct

Sistema web para **asignación de horarios**, **gestión de aulas, materias y grupos**, y **asistencia docente** (FICCT).  
Desarrollado con **Laravel + PostgreSQL + Vite + Tailwind**.

## ✨ Módulos principales
- Gestión de **usuarios, roles y permisos**
- Catálogos: **materias, grupos, horarios, aulas**
- **Asignación** materia–grupo–aula–horario (slots)
- **Registro de asistencia** (manual / QR futuro)
- **Reportes**: asistencias por día/materia, uso de aulas, colisiones de horario

## 🛠️ Stack
- PHP 8.2 · Laravel 10/11  
- PostgreSQL  
- Vite + TailwindCSS  
- Blade

## ✅ Requisitos
- PHP 8.2+, Composer
- Node.js 18+
- PostgreSQL 13+
- Extensiones PHP: `pdo_pgsql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`

## 🚀 Instalación local

```bash
# 1) Clonar
git clone https://github.com/WalterRoAg/DocentesFicct.git
cd DocentesFicct

# 2) Dependencias
composer install
npm install

# 3) Variables de entorno
cp .env.example .env
