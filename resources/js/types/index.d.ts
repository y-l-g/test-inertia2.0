import { Config } from "ziggy-js";

export interface User {
  id: number;
  name: string;
  email: string;
  email_verified_at?: string;
  permissions: string[];
  roles: string[];
}

export type PaginatedData<T = any> = {
  data: T[];
  links: Record<string, string>;
};

export type DeferredData<T = any> = {
  data: T[];
};

export type Comment = {
  id: number;
  comment: string;
  created_at: string;
  user: User;
};

export type Feature = {
  id: number;
  name: string;
  description: string;
  created_at: string;
  user: User;
  upvote_count: number;
  user_vote?: number | null;
  comments_count: number;
};

export type PageProps<
  T extends Record<string, unknown> = Record<string, unknown>
> = T & {
  auth: {
    user: User;
  };
  ziggy: Config & { location: string };
};
