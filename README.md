# Laravel 10 - Student Management API

This document defines the access control and permissions for various user roles in the Student Management API. The roles, permissions, and CRUD operations are outlined below, detailing the specific actions each role can perform.

---

## Roles

The system includes the following roles, each with unique permissions:

1. **Student**
2. **Program Chair**
3. **Dean**
4. **Admin**
5. **Super Admin**

---

## Permissions

The permissions for each role are categorized as follows:

- **Viewing Records**: Permissions to view lists or individual records.
- **Creating Users**: Permissions to create new users of specific roles.
- **Updating Users**: Permissions to modify user data.
- **Deleting Users**: Permissions to remove users from the system.

### 1. Viewing Records (`index`)

#### Overview
- **Student**: Cannot view any records.
- **Program Chair**: Can only view student records.
- **Dean**: Can view student and program chair records.
- **Admin**: Can view student, program chair, and dean records.
- **Super Admin**: Can view all records.

| Role           | View Student Records | View Program Chair Records | View Dean Records | View Admin Records | View Super Admin Records |
|----------------|----------------------|----------------------------|-------------------|--------------------|--------------------------|
| Student        | ❌                   | ❌                         | ❌                | ❌                 | ❌                       |
| Program Chair  | ✅                   | ❌                         | ❌                | ❌                 | ❌                       |
| Dean           | ✅                   | ✅                         | ❌                | ❌                 | ❌                       |
| Admin          | ✅                   | ✅                         | ✅                | ❌                 | ❌                       |
| Super Admin    | ✅                   | ✅                         | ✅                | ✅                 | ✅                       |

### 2. Viewing Individual Records (`show`)

#### Overview
- **Student**: Can only view their own record.
- **Program Chair**: Can view any student record and their own.
- **Dean**: Can view any student, program chair record, and their own.
- **Admin**: Can view any student, program chair, dean record, and their own.
- **Super Admin**: Can view any individual record.

| Role           | View Own Record | View Student Records | View Program Chair Records | View Dean Records | View Admin Records | View Super Admin Records |
|----------------|-----------------|----------------------|----------------------------|-------------------|--------------------|--------------------------|
| Student        | ✅              | ❌                   | ❌                         | ❌                | ❌                 | ❌                       |
| Program Chair  | ✅              | ✅                   | ❌                         | ❌                | ❌                 | ❌                       |
| Dean           | ✅              | ✅                   | ✅                         | ❌                | ❌                 | ❌                       |
| Admin          | ✅              | ✅                   | ✅                         | ✅                | ❌                 | ❌                       |
| Super Admin    | ✅              | ✅                   | ✅                         | ✅                | ✅                 | ✅                       |

### 3. Creating Users

#### Overview
- **Student**: Cannot create any users.
- **Program Chair**: Can create student users only.
- **Dean**: Can create student and program chair users only.
- **Admin**: Can create any user except for admin and super admin.
- **Super Admin**: Can create users of any role.

| Role           | Create Student | Create Program Chair | Create Dean | Create Admin | Create Super Admin |
|----------------|----------------|----------------------|-------------|--------------|---------------------|
| Student        | ❌             | ❌                   | ❌          | ❌           | ❌                  |
| Program Chair  | ✅             | ❌                   | ❌          | ❌           | ❌                  |
| Dean           | ✅             | ✅                   | ❌          | ❌           | ❌                  |
| Admin          | ✅             | ✅                   | ✅          | ❌           | ❌                  |
| Super Admin    | ✅             | ✅                   | ✅          | ✅           | ✅                  |

### 4. Updating Users

#### Overview
- **Role updates**: Only allowed by the super admin.
- **Student number updates**: Allowed by dean, admin, and super admin only.
- **Student**: Can only update their own record.
- **Program Chair**: Can update student records and their own record.
- **Dean**: Can update student, program chair records, and their own record.
- **Admin**: Can update student, program chair, dean records, and their own.
- **Super Admin**: Can update any record.

| Role           | Update Own Record | Update Student Records | Update Program Chair Records | Update Dean Records | Update Admin Records | Update Super Admin Records |
|----------------|-------------------|------------------------|------------------------------|---------------------|----------------------|----------------------------|
| Student        | ✅                | ❌                     | ❌                           | ❌                  | ❌                   | ❌                         |
| Program Chair  | ✅                | ✅                     | ❌                           | ❌                  | ❌                   | ❌                         |
| Dean           | ✅                | ✅                     | ✅                           | ❌                  | ❌                   | ❌                         |
| Admin          | ✅                | ✅                     | ✅                           | ✅                  | ❌                   | ❌                         |
| Super Admin    | ✅                | ✅                     | ✅                           | ✅                  | ✅                   | ✅                         |

### 5. Deleting Users

#### Overview
- **Student and Program Chair**: Cannot delete any records.
- **Dean**: Can only delete student and program chair records.
- **Admin**: Can delete student, program chair, and dean records.
- **Super Admin**: Can delete any record.

| Role           | Delete Student Records | Delete Program Chair Records | Delete Dean Records | Delete Admin Records | Delete Super Admin Records |
|----------------|------------------------|------------------------------|---------------------|----------------------|----------------------------|
| Student        | ❌                     | ❌                           | ❌                  | ❌                   | ❌                         |
| Program Chair  | ❌                     | ❌                           | ❌                  | ❌                   | ❌                         |
| Dean           | ✅                     | ✅                           | ❌                  | ❌                   | ❌                         |
| Admin          | ✅                     | ✅                           | ✅                  | ❌                   | ❌                         |
| Super Admin    | ✅                     | ✅                           | ✅                  | ✅                   | ✅                         |

---

## Summary

This permission matrix defines the access levels and restrictions for each user role within the Laravel 10 Student Management API. Implementing this structure ensures controlled access to sensitive information and enforces hierarchical authorization to protect data integrity.