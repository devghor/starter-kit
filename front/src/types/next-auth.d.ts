import type { DefaultSession } from 'next-auth';
import type { Company } from '@/types';

declare module 'next-auth' {
  interface Session {
    user: {
      id: string;
      company: Company | null;
    } & DefaultSession['user'];
    accessToken: string;
    permissions: string[];
  }

  interface User {
    accessToken?: string;
    company?: Company | null;
    permissions?: string[];
  }
}

declare module 'next-auth/jwt' {
  interface JWT {
    id?: string;
    accessToken?: string;
    company?: Company | null;
    permissions?: string[];
  }
}
