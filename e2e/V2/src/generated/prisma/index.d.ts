
/**
 * Client
**/

import * as runtime from './runtime/library.js';
import $Types = runtime.Types // general types
import $Public = runtime.Types.Public
import $Utils = runtime.Types.Utils
import $Extensions = runtime.Types.Extensions
import $Result = runtime.Types.Result

export type PrismaPromise<T> = $Public.PrismaPromise<T>


/**
 * Model ps_configuration
 * 
 */
export type ps_configuration = $Result.DefaultSelection<Prisma.$ps_configurationPayload>
/**
 * Model ps_eventbus_incremental_sync
 * 
 */
export type ps_eventbus_incremental_sync = $Result.DefaultSelection<Prisma.$ps_eventbus_incremental_syncPayload>
/**
 * Model ps_eventbus_job
 * 
 */
export type ps_eventbus_job = $Result.DefaultSelection<Prisma.$ps_eventbus_jobPayload>
/**
 * Model ps_eventbus_live_sync
 * 
 */
export type ps_eventbus_live_sync = $Result.DefaultSelection<Prisma.$ps_eventbus_live_syncPayload>
/**
 * Model ps_eventbus_type_sync
 * 
 */
export type ps_eventbus_type_sync = $Result.DefaultSelection<Prisma.$ps_eventbus_type_syncPayload>

/**
 * ##  Prisma Client ʲˢ
 *
 * Type-safe database client for TypeScript & Node.js
 * @example
 * ```
 * const prisma = new PrismaClient()
 * // Fetch zero or more Ps_configurations
 * const ps_configurations = await prisma.ps_configuration.findMany()
 * ```
 *
 *
 * Read more in our [docs](https://www.prisma.io/docs/reference/tools-and-interfaces/prisma-client).
 */
export class PrismaClient<
  ClientOptions extends Prisma.PrismaClientOptions = Prisma.PrismaClientOptions,
  U = 'log' extends keyof ClientOptions ? ClientOptions['log'] extends Array<Prisma.LogLevel | Prisma.LogDefinition> ? Prisma.GetEvents<ClientOptions['log']> : never : never,
  ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs
> {
  [K: symbol]: { types: Prisma.TypeMap<ExtArgs>['other'] }

    /**
   * ##  Prisma Client ʲˢ
   *
   * Type-safe database client for TypeScript & Node.js
   * @example
   * ```
   * const prisma = new PrismaClient()
   * // Fetch zero or more Ps_configurations
   * const ps_configurations = await prisma.ps_configuration.findMany()
   * ```
   *
   *
   * Read more in our [docs](https://www.prisma.io/docs/reference/tools-and-interfaces/prisma-client).
   */

  constructor(optionsArg ?: Prisma.Subset<ClientOptions, Prisma.PrismaClientOptions>);
  $on<V extends U>(eventType: V, callback: (event: V extends 'query' ? Prisma.QueryEvent : Prisma.LogEvent) => void): PrismaClient;

  /**
   * Connect with the database
   */
  $connect(): $Utils.JsPromise<void>;

  /**
   * Disconnect from the database
   */
  $disconnect(): $Utils.JsPromise<void>;

  /**
   * Add a middleware
   * @deprecated since 4.16.0. For new code, prefer client extensions instead.
   * @see https://pris.ly/d/extensions
   */
  $use(cb: Prisma.Middleware): void

/**
   * Executes a prepared raw query and returns the number of affected rows.
   * @example
   * ```
   * const result = await prisma.$executeRaw`UPDATE User SET cool = ${true} WHERE email = ${'user@email.com'};`
   * ```
   *
   * Read more in our [docs](https://www.prisma.io/docs/reference/tools-and-interfaces/prisma-client/raw-database-access).
   */
  $executeRaw<T = unknown>(query: TemplateStringsArray | Prisma.Sql, ...values: any[]): Prisma.PrismaPromise<number>;

  /**
   * Executes a raw query and returns the number of affected rows.
   * Susceptible to SQL injections, see documentation.
   * @example
   * ```
   * const result = await prisma.$executeRawUnsafe('UPDATE User SET cool = $1 WHERE email = $2 ;', true, 'user@email.com')
   * ```
   *
   * Read more in our [docs](https://www.prisma.io/docs/reference/tools-and-interfaces/prisma-client/raw-database-access).
   */
  $executeRawUnsafe<T = unknown>(query: string, ...values: any[]): Prisma.PrismaPromise<number>;

  /**
   * Performs a prepared raw query and returns the `SELECT` data.
   * @example
   * ```
   * const result = await prisma.$queryRaw`SELECT * FROM User WHERE id = ${1} OR email = ${'user@email.com'};`
   * ```
   *
   * Read more in our [docs](https://www.prisma.io/docs/reference/tools-and-interfaces/prisma-client/raw-database-access).
   */
  $queryRaw<T = unknown>(query: TemplateStringsArray | Prisma.Sql, ...values: any[]): Prisma.PrismaPromise<T>;

  /**
   * Performs a raw query and returns the `SELECT` data.
   * Susceptible to SQL injections, see documentation.
   * @example
   * ```
   * const result = await prisma.$queryRawUnsafe('SELECT * FROM User WHERE id = $1 OR email = $2;', 1, 'user@email.com')
   * ```
   *
   * Read more in our [docs](https://www.prisma.io/docs/reference/tools-and-interfaces/prisma-client/raw-database-access).
   */
  $queryRawUnsafe<T = unknown>(query: string, ...values: any[]): Prisma.PrismaPromise<T>;


  /**
   * Allows the running of a sequence of read/write operations that are guaranteed to either succeed or fail as a whole.
   * @example
   * ```
   * const [george, bob, alice] = await prisma.$transaction([
   *   prisma.user.create({ data: { name: 'George' } }),
   *   prisma.user.create({ data: { name: 'Bob' } }),
   *   prisma.user.create({ data: { name: 'Alice' } }),
   * ])
   * ```
   * 
   * Read more in our [docs](https://www.prisma.io/docs/concepts/components/prisma-client/transactions).
   */
  $transaction<P extends Prisma.PrismaPromise<any>[]>(arg: [...P], options?: { isolationLevel?: Prisma.TransactionIsolationLevel }): $Utils.JsPromise<runtime.Types.Utils.UnwrapTuple<P>>

  $transaction<R>(fn: (prisma: Omit<PrismaClient, runtime.ITXClientDenyList>) => $Utils.JsPromise<R>, options?: { maxWait?: number, timeout?: number, isolationLevel?: Prisma.TransactionIsolationLevel }): $Utils.JsPromise<R>


  $extends: $Extensions.ExtendsHook<"extends", Prisma.TypeMapCb<ClientOptions>, ExtArgs, $Utils.Call<Prisma.TypeMapCb<ClientOptions>, {
    extArgs: ExtArgs
  }>>

      /**
   * `prisma.ps_configuration`: Exposes CRUD operations for the **ps_configuration** model.
    * Example usage:
    * ```ts
    * // Fetch zero or more Ps_configurations
    * const ps_configurations = await prisma.ps_configuration.findMany()
    * ```
    */
  get ps_configuration(): Prisma.ps_configurationDelegate<ExtArgs, ClientOptions>;

  /**
   * `prisma.ps_eventbus_incremental_sync`: Exposes CRUD operations for the **ps_eventbus_incremental_sync** model.
    * Example usage:
    * ```ts
    * // Fetch zero or more Ps_eventbus_incremental_syncs
    * const ps_eventbus_incremental_syncs = await prisma.ps_eventbus_incremental_sync.findMany()
    * ```
    */
  get ps_eventbus_incremental_sync(): Prisma.ps_eventbus_incremental_syncDelegate<ExtArgs, ClientOptions>;

  /**
   * `prisma.ps_eventbus_job`: Exposes CRUD operations for the **ps_eventbus_job** model.
    * Example usage:
    * ```ts
    * // Fetch zero or more Ps_eventbus_jobs
    * const ps_eventbus_jobs = await prisma.ps_eventbus_job.findMany()
    * ```
    */
  get ps_eventbus_job(): Prisma.ps_eventbus_jobDelegate<ExtArgs, ClientOptions>;

  /**
   * `prisma.ps_eventbus_live_sync`: Exposes CRUD operations for the **ps_eventbus_live_sync** model.
    * Example usage:
    * ```ts
    * // Fetch zero or more Ps_eventbus_live_syncs
    * const ps_eventbus_live_syncs = await prisma.ps_eventbus_live_sync.findMany()
    * ```
    */
  get ps_eventbus_live_sync(): Prisma.ps_eventbus_live_syncDelegate<ExtArgs, ClientOptions>;

  /**
   * `prisma.ps_eventbus_type_sync`: Exposes CRUD operations for the **ps_eventbus_type_sync** model.
    * Example usage:
    * ```ts
    * // Fetch zero or more Ps_eventbus_type_syncs
    * const ps_eventbus_type_syncs = await prisma.ps_eventbus_type_sync.findMany()
    * ```
    */
  get ps_eventbus_type_sync(): Prisma.ps_eventbus_type_syncDelegate<ExtArgs, ClientOptions>;
}

export namespace Prisma {
  export import DMMF = runtime.DMMF

  export type PrismaPromise<T> = $Public.PrismaPromise<T>

  /**
   * Validator
   */
  export import validator = runtime.Public.validator

  /**
   * Prisma Errors
   */
  export import PrismaClientKnownRequestError = runtime.PrismaClientKnownRequestError
  export import PrismaClientUnknownRequestError = runtime.PrismaClientUnknownRequestError
  export import PrismaClientRustPanicError = runtime.PrismaClientRustPanicError
  export import PrismaClientInitializationError = runtime.PrismaClientInitializationError
  export import PrismaClientValidationError = runtime.PrismaClientValidationError

  /**
   * Re-export of sql-template-tag
   */
  export import sql = runtime.sqltag
  export import empty = runtime.empty
  export import join = runtime.join
  export import raw = runtime.raw
  export import Sql = runtime.Sql



  /**
   * Decimal.js
   */
  export import Decimal = runtime.Decimal

  export type DecimalJsLike = runtime.DecimalJsLike

  /**
   * Metrics
   */
  export type Metrics = runtime.Metrics
  export type Metric<T> = runtime.Metric<T>
  export type MetricHistogram = runtime.MetricHistogram
  export type MetricHistogramBucket = runtime.MetricHistogramBucket

  /**
  * Extensions
  */
  export import Extension = $Extensions.UserArgs
  export import getExtensionContext = runtime.Extensions.getExtensionContext
  export import Args = $Public.Args
  export import Payload = $Public.Payload
  export import Result = $Public.Result
  export import Exact = $Public.Exact

  /**
   * Prisma Client JS version: 6.7.0
   * Query Engine version: 3cff47a7f5d65c3ea74883f1d736e41d68ce91ed
   */
  export type PrismaVersion = {
    client: string
  }

  export const prismaVersion: PrismaVersion

  /**
   * Utility Types
   */


  export import JsonObject = runtime.JsonObject
  export import JsonArray = runtime.JsonArray
  export import JsonValue = runtime.JsonValue
  export import InputJsonObject = runtime.InputJsonObject
  export import InputJsonArray = runtime.InputJsonArray
  export import InputJsonValue = runtime.InputJsonValue

  /**
   * Types of the values used to represent different kinds of `null` values when working with JSON fields.
   *
   * @see https://www.prisma.io/docs/concepts/components/prisma-client/working-with-fields/working-with-json-fields#filtering-on-a-json-field
   */
  namespace NullTypes {
    /**
    * Type of `Prisma.DbNull`.
    *
    * You cannot use other instances of this class. Please use the `Prisma.DbNull` value.
    *
    * @see https://www.prisma.io/docs/concepts/components/prisma-client/working-with-fields/working-with-json-fields#filtering-on-a-json-field
    */
    class DbNull {
      private DbNull: never
      private constructor()
    }

    /**
    * Type of `Prisma.JsonNull`.
    *
    * You cannot use other instances of this class. Please use the `Prisma.JsonNull` value.
    *
    * @see https://www.prisma.io/docs/concepts/components/prisma-client/working-with-fields/working-with-json-fields#filtering-on-a-json-field
    */
    class JsonNull {
      private JsonNull: never
      private constructor()
    }

    /**
    * Type of `Prisma.AnyNull`.
    *
    * You cannot use other instances of this class. Please use the `Prisma.AnyNull` value.
    *
    * @see https://www.prisma.io/docs/concepts/components/prisma-client/working-with-fields/working-with-json-fields#filtering-on-a-json-field
    */
    class AnyNull {
      private AnyNull: never
      private constructor()
    }
  }

  /**
   * Helper for filtering JSON entries that have `null` on the database (empty on the db)
   *
   * @see https://www.prisma.io/docs/concepts/components/prisma-client/working-with-fields/working-with-json-fields#filtering-on-a-json-field
   */
  export const DbNull: NullTypes.DbNull

  /**
   * Helper for filtering JSON entries that have JSON `null` values (not empty on the db)
   *
   * @see https://www.prisma.io/docs/concepts/components/prisma-client/working-with-fields/working-with-json-fields#filtering-on-a-json-field
   */
  export const JsonNull: NullTypes.JsonNull

  /**
   * Helper for filtering JSON entries that are `Prisma.DbNull` or `Prisma.JsonNull`
   *
   * @see https://www.prisma.io/docs/concepts/components/prisma-client/working-with-fields/working-with-json-fields#filtering-on-a-json-field
   */
  export const AnyNull: NullTypes.AnyNull

  type SelectAndInclude = {
    select: any
    include: any
  }

  type SelectAndOmit = {
    select: any
    omit: any
  }

  /**
   * Get the type of the value, that the Promise holds.
   */
  export type PromiseType<T extends PromiseLike<any>> = T extends PromiseLike<infer U> ? U : T;

  /**
   * Get the return type of a function which returns a Promise.
   */
  export type PromiseReturnType<T extends (...args: any) => $Utils.JsPromise<any>> = PromiseType<ReturnType<T>>

  /**
   * From T, pick a set of properties whose keys are in the union K
   */
  type Prisma__Pick<T, K extends keyof T> = {
      [P in K]: T[P];
  };


  export type Enumerable<T> = T | Array<T>;

  export type RequiredKeys<T> = {
    [K in keyof T]-?: {} extends Prisma__Pick<T, K> ? never : K
  }[keyof T]

  export type TruthyKeys<T> = keyof {
    [K in keyof T as T[K] extends false | undefined | null ? never : K]: K
  }

  export type TrueKeys<T> = TruthyKeys<Prisma__Pick<T, RequiredKeys<T>>>

  /**
   * Subset
   * @desc From `T` pick properties that exist in `U`. Simple version of Intersection
   */
  export type Subset<T, U> = {
    [key in keyof T]: key extends keyof U ? T[key] : never;
  };

  /**
   * SelectSubset
   * @desc From `T` pick properties that exist in `U`. Simple version of Intersection.
   * Additionally, it validates, if both select and include are present. If the case, it errors.
   */
  export type SelectSubset<T, U> = {
    [key in keyof T]: key extends keyof U ? T[key] : never
  } &
    (T extends SelectAndInclude
      ? 'Please either choose `select` or `include`.'
      : T extends SelectAndOmit
        ? 'Please either choose `select` or `omit`.'
        : {})

  /**
   * Subset + Intersection
   * @desc From `T` pick properties that exist in `U` and intersect `K`
   */
  export type SubsetIntersection<T, U, K> = {
    [key in keyof T]: key extends keyof U ? T[key] : never
  } &
    K

  type Without<T, U> = { [P in Exclude<keyof T, keyof U>]?: never };

  /**
   * XOR is needed to have a real mutually exclusive union type
   * https://stackoverflow.com/questions/42123407/does-typescript-support-mutually-exclusive-types
   */
  type XOR<T, U> =
    T extends object ?
    U extends object ?
      (Without<T, U> & U) | (Without<U, T> & T)
    : U : T


  /**
   * Is T a Record?
   */
  type IsObject<T extends any> = T extends Array<any>
  ? False
  : T extends Date
  ? False
  : T extends Uint8Array
  ? False
  : T extends BigInt
  ? False
  : T extends object
  ? True
  : False


  /**
   * If it's T[], return T
   */
  export type UnEnumerate<T extends unknown> = T extends Array<infer U> ? U : T

  /**
   * From ts-toolbelt
   */

  type __Either<O extends object, K extends Key> = Omit<O, K> &
    {
      // Merge all but K
      [P in K]: Prisma__Pick<O, P & keyof O> // With K possibilities
    }[K]

  type EitherStrict<O extends object, K extends Key> = Strict<__Either<O, K>>

  type EitherLoose<O extends object, K extends Key> = ComputeRaw<__Either<O, K>>

  type _Either<
    O extends object,
    K extends Key,
    strict extends Boolean
  > = {
    1: EitherStrict<O, K>
    0: EitherLoose<O, K>
  }[strict]

  type Either<
    O extends object,
    K extends Key,
    strict extends Boolean = 1
  > = O extends unknown ? _Either<O, K, strict> : never

  export type Union = any

  type PatchUndefined<O extends object, O1 extends object> = {
    [K in keyof O]: O[K] extends undefined ? At<O1, K> : O[K]
  } & {}

  /** Helper Types for "Merge" **/
  export type IntersectOf<U extends Union> = (
    U extends unknown ? (k: U) => void : never
  ) extends (k: infer I) => void
    ? I
    : never

  export type Overwrite<O extends object, O1 extends object> = {
      [K in keyof O]: K extends keyof O1 ? O1[K] : O[K];
  } & {};

  type _Merge<U extends object> = IntersectOf<Overwrite<U, {
      [K in keyof U]-?: At<U, K>;
  }>>;

  type Key = string | number | symbol;
  type AtBasic<O extends object, K extends Key> = K extends keyof O ? O[K] : never;
  type AtStrict<O extends object, K extends Key> = O[K & keyof O];
  type AtLoose<O extends object, K extends Key> = O extends unknown ? AtStrict<O, K> : never;
  export type At<O extends object, K extends Key, strict extends Boolean = 1> = {
      1: AtStrict<O, K>;
      0: AtLoose<O, K>;
  }[strict];

  export type ComputeRaw<A extends any> = A extends Function ? A : {
    [K in keyof A]: A[K];
  } & {};

  export type OptionalFlat<O> = {
    [K in keyof O]?: O[K];
  } & {};

  type _Record<K extends keyof any, T> = {
    [P in K]: T;
  };

  // cause typescript not to expand types and preserve names
  type NoExpand<T> = T extends unknown ? T : never;

  // this type assumes the passed object is entirely optional
  type AtLeast<O extends object, K extends string> = NoExpand<
    O extends unknown
    ? | (K extends keyof O ? { [P in K]: O[P] } & O : O)
      | {[P in keyof O as P extends K ? P : never]-?: O[P]} & O
    : never>;

  type _Strict<U, _U = U> = U extends unknown ? U & OptionalFlat<_Record<Exclude<Keys<_U>, keyof U>, never>> : never;

  export type Strict<U extends object> = ComputeRaw<_Strict<U>>;
  /** End Helper Types for "Merge" **/

  export type Merge<U extends object> = ComputeRaw<_Merge<Strict<U>>>;

  /**
  A [[Boolean]]
  */
  export type Boolean = True | False

  // /**
  // 1
  // */
  export type True = 1

  /**
  0
  */
  export type False = 0

  export type Not<B extends Boolean> = {
    0: 1
    1: 0
  }[B]

  export type Extends<A1 extends any, A2 extends any> = [A1] extends [never]
    ? 0 // anything `never` is false
    : A1 extends A2
    ? 1
    : 0

  export type Has<U extends Union, U1 extends Union> = Not<
    Extends<Exclude<U1, U>, U1>
  >

  export type Or<B1 extends Boolean, B2 extends Boolean> = {
    0: {
      0: 0
      1: 1
    }
    1: {
      0: 1
      1: 1
    }
  }[B1][B2]

  export type Keys<U extends Union> = U extends unknown ? keyof U : never

  type Cast<A, B> = A extends B ? A : B;

  export const type: unique symbol;



  /**
   * Used by group by
   */

  export type GetScalarType<T, O> = O extends object ? {
    [P in keyof T]: P extends keyof O
      ? O[P]
      : never
  } : never

  type FieldPaths<
    T,
    U = Omit<T, '_avg' | '_sum' | '_count' | '_min' | '_max'>
  > = IsObject<T> extends True ? U : T

  type GetHavingFields<T> = {
    [K in keyof T]: Or<
      Or<Extends<'OR', K>, Extends<'AND', K>>,
      Extends<'NOT', K>
    > extends True
      ? // infer is only needed to not hit TS limit
        // based on the brilliant idea of Pierre-Antoine Mills
        // https://github.com/microsoft/TypeScript/issues/30188#issuecomment-478938437
        T[K] extends infer TK
        ? GetHavingFields<UnEnumerate<TK> extends object ? Merge<UnEnumerate<TK>> : never>
        : never
      : {} extends FieldPaths<T[K]>
      ? never
      : K
  }[keyof T]

  /**
   * Convert tuple to union
   */
  type _TupleToUnion<T> = T extends (infer E)[] ? E : never
  type TupleToUnion<K extends readonly any[]> = _TupleToUnion<K>
  type MaybeTupleToUnion<T> = T extends any[] ? TupleToUnion<T> : T

  /**
   * Like `Pick`, but additionally can also accept an array of keys
   */
  type PickEnumerable<T, K extends Enumerable<keyof T> | keyof T> = Prisma__Pick<T, MaybeTupleToUnion<K>>

  /**
   * Exclude all keys with underscores
   */
  type ExcludeUnderscoreKeys<T extends string> = T extends `_${string}` ? never : T


  export type FieldRef<Model, FieldType> = runtime.FieldRef<Model, FieldType>

  type FieldRefInputType<Model, FieldType> = Model extends never ? never : FieldRef<Model, FieldType>


  export const ModelName: {
    ps_configuration: 'ps_configuration',
    ps_eventbus_incremental_sync: 'ps_eventbus_incremental_sync',
    ps_eventbus_job: 'ps_eventbus_job',
    ps_eventbus_live_sync: 'ps_eventbus_live_sync',
    ps_eventbus_type_sync: 'ps_eventbus_type_sync'
  };

  export type ModelName = (typeof ModelName)[keyof typeof ModelName]


  export type Datasources = {
    db?: Datasource
  }

  interface TypeMapCb<ClientOptions = {}> extends $Utils.Fn<{extArgs: $Extensions.InternalArgs }, $Utils.Record<string, any>> {
    returns: Prisma.TypeMap<this['params']['extArgs'], ClientOptions extends { omit: infer OmitOptions } ? OmitOptions : {}>
  }

  export type TypeMap<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs, GlobalOmitOptions = {}> = {
    globalOmitOptions: {
      omit: GlobalOmitOptions
    }
    meta: {
      modelProps: "ps_configuration" | "ps_eventbus_incremental_sync" | "ps_eventbus_job" | "ps_eventbus_live_sync" | "ps_eventbus_type_sync"
      txIsolationLevel: Prisma.TransactionIsolationLevel
    }
    model: {
      ps_configuration: {
        payload: Prisma.$ps_configurationPayload<ExtArgs>
        fields: Prisma.ps_configurationFieldRefs
        operations: {
          findUnique: {
            args: Prisma.ps_configurationFindUniqueArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_configurationPayload> | null
          }
          findUniqueOrThrow: {
            args: Prisma.ps_configurationFindUniqueOrThrowArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_configurationPayload>
          }
          findFirst: {
            args: Prisma.ps_configurationFindFirstArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_configurationPayload> | null
          }
          findFirstOrThrow: {
            args: Prisma.ps_configurationFindFirstOrThrowArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_configurationPayload>
          }
          findMany: {
            args: Prisma.ps_configurationFindManyArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_configurationPayload>[]
          }
          create: {
            args: Prisma.ps_configurationCreateArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_configurationPayload>
          }
          createMany: {
            args: Prisma.ps_configurationCreateManyArgs<ExtArgs>
            result: BatchPayload
          }
          delete: {
            args: Prisma.ps_configurationDeleteArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_configurationPayload>
          }
          update: {
            args: Prisma.ps_configurationUpdateArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_configurationPayload>
          }
          deleteMany: {
            args: Prisma.ps_configurationDeleteManyArgs<ExtArgs>
            result: BatchPayload
          }
          updateMany: {
            args: Prisma.ps_configurationUpdateManyArgs<ExtArgs>
            result: BatchPayload
          }
          upsert: {
            args: Prisma.ps_configurationUpsertArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_configurationPayload>
          }
          aggregate: {
            args: Prisma.Ps_configurationAggregateArgs<ExtArgs>
            result: $Utils.Optional<AggregatePs_configuration>
          }
          groupBy: {
            args: Prisma.ps_configurationGroupByArgs<ExtArgs>
            result: $Utils.Optional<Ps_configurationGroupByOutputType>[]
          }
          count: {
            args: Prisma.ps_configurationCountArgs<ExtArgs>
            result: $Utils.Optional<Ps_configurationCountAggregateOutputType> | number
          }
        }
      }
      ps_eventbus_incremental_sync: {
        payload: Prisma.$ps_eventbus_incremental_syncPayload<ExtArgs>
        fields: Prisma.ps_eventbus_incremental_syncFieldRefs
        operations: {
          findUnique: {
            args: Prisma.ps_eventbus_incremental_syncFindUniqueArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_eventbus_incremental_syncPayload> | null
          }
          findUniqueOrThrow: {
            args: Prisma.ps_eventbus_incremental_syncFindUniqueOrThrowArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_eventbus_incremental_syncPayload>
          }
          findFirst: {
            args: Prisma.ps_eventbus_incremental_syncFindFirstArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_eventbus_incremental_syncPayload> | null
          }
          findFirstOrThrow: {
            args: Prisma.ps_eventbus_incremental_syncFindFirstOrThrowArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_eventbus_incremental_syncPayload>
          }
          findMany: {
            args: Prisma.ps_eventbus_incremental_syncFindManyArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_eventbus_incremental_syncPayload>[]
          }
          create: {
            args: Prisma.ps_eventbus_incremental_syncCreateArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_eventbus_incremental_syncPayload>
          }
          createMany: {
            args: Prisma.ps_eventbus_incremental_syncCreateManyArgs<ExtArgs>
            result: BatchPayload
          }
          delete: {
            args: Prisma.ps_eventbus_incremental_syncDeleteArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_eventbus_incremental_syncPayload>
          }
          update: {
            args: Prisma.ps_eventbus_incremental_syncUpdateArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_eventbus_incremental_syncPayload>
          }
          deleteMany: {
            args: Prisma.ps_eventbus_incremental_syncDeleteManyArgs<ExtArgs>
            result: BatchPayload
          }
          updateMany: {
            args: Prisma.ps_eventbus_incremental_syncUpdateManyArgs<ExtArgs>
            result: BatchPayload
          }
          upsert: {
            args: Prisma.ps_eventbus_incremental_syncUpsertArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_eventbus_incremental_syncPayload>
          }
          aggregate: {
            args: Prisma.Ps_eventbus_incremental_syncAggregateArgs<ExtArgs>
            result: $Utils.Optional<AggregatePs_eventbus_incremental_sync>
          }
          groupBy: {
            args: Prisma.ps_eventbus_incremental_syncGroupByArgs<ExtArgs>
            result: $Utils.Optional<Ps_eventbus_incremental_syncGroupByOutputType>[]
          }
          count: {
            args: Prisma.ps_eventbus_incremental_syncCountArgs<ExtArgs>
            result: $Utils.Optional<Ps_eventbus_incremental_syncCountAggregateOutputType> | number
          }
        }
      }
      ps_eventbus_job: {
        payload: Prisma.$ps_eventbus_jobPayload<ExtArgs>
        fields: Prisma.ps_eventbus_jobFieldRefs
        operations: {
          findUnique: {
            args: Prisma.ps_eventbus_jobFindUniqueArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_eventbus_jobPayload> | null
          }
          findUniqueOrThrow: {
            args: Prisma.ps_eventbus_jobFindUniqueOrThrowArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_eventbus_jobPayload>
          }
          findFirst: {
            args: Prisma.ps_eventbus_jobFindFirstArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_eventbus_jobPayload> | null
          }
          findFirstOrThrow: {
            args: Prisma.ps_eventbus_jobFindFirstOrThrowArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_eventbus_jobPayload>
          }
          findMany: {
            args: Prisma.ps_eventbus_jobFindManyArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_eventbus_jobPayload>[]
          }
          create: {
            args: Prisma.ps_eventbus_jobCreateArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_eventbus_jobPayload>
          }
          createMany: {
            args: Prisma.ps_eventbus_jobCreateManyArgs<ExtArgs>
            result: BatchPayload
          }
          delete: {
            args: Prisma.ps_eventbus_jobDeleteArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_eventbus_jobPayload>
          }
          update: {
            args: Prisma.ps_eventbus_jobUpdateArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_eventbus_jobPayload>
          }
          deleteMany: {
            args: Prisma.ps_eventbus_jobDeleteManyArgs<ExtArgs>
            result: BatchPayload
          }
          updateMany: {
            args: Prisma.ps_eventbus_jobUpdateManyArgs<ExtArgs>
            result: BatchPayload
          }
          upsert: {
            args: Prisma.ps_eventbus_jobUpsertArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_eventbus_jobPayload>
          }
          aggregate: {
            args: Prisma.Ps_eventbus_jobAggregateArgs<ExtArgs>
            result: $Utils.Optional<AggregatePs_eventbus_job>
          }
          groupBy: {
            args: Prisma.ps_eventbus_jobGroupByArgs<ExtArgs>
            result: $Utils.Optional<Ps_eventbus_jobGroupByOutputType>[]
          }
          count: {
            args: Prisma.ps_eventbus_jobCountArgs<ExtArgs>
            result: $Utils.Optional<Ps_eventbus_jobCountAggregateOutputType> | number
          }
        }
      }
      ps_eventbus_live_sync: {
        payload: Prisma.$ps_eventbus_live_syncPayload<ExtArgs>
        fields: Prisma.ps_eventbus_live_syncFieldRefs
        operations: {
          findUnique: {
            args: Prisma.ps_eventbus_live_syncFindUniqueArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_eventbus_live_syncPayload> | null
          }
          findUniqueOrThrow: {
            args: Prisma.ps_eventbus_live_syncFindUniqueOrThrowArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_eventbus_live_syncPayload>
          }
          findFirst: {
            args: Prisma.ps_eventbus_live_syncFindFirstArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_eventbus_live_syncPayload> | null
          }
          findFirstOrThrow: {
            args: Prisma.ps_eventbus_live_syncFindFirstOrThrowArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_eventbus_live_syncPayload>
          }
          findMany: {
            args: Prisma.ps_eventbus_live_syncFindManyArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_eventbus_live_syncPayload>[]
          }
          create: {
            args: Prisma.ps_eventbus_live_syncCreateArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_eventbus_live_syncPayload>
          }
          createMany: {
            args: Prisma.ps_eventbus_live_syncCreateManyArgs<ExtArgs>
            result: BatchPayload
          }
          delete: {
            args: Prisma.ps_eventbus_live_syncDeleteArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_eventbus_live_syncPayload>
          }
          update: {
            args: Prisma.ps_eventbus_live_syncUpdateArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_eventbus_live_syncPayload>
          }
          deleteMany: {
            args: Prisma.ps_eventbus_live_syncDeleteManyArgs<ExtArgs>
            result: BatchPayload
          }
          updateMany: {
            args: Prisma.ps_eventbus_live_syncUpdateManyArgs<ExtArgs>
            result: BatchPayload
          }
          upsert: {
            args: Prisma.ps_eventbus_live_syncUpsertArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_eventbus_live_syncPayload>
          }
          aggregate: {
            args: Prisma.Ps_eventbus_live_syncAggregateArgs<ExtArgs>
            result: $Utils.Optional<AggregatePs_eventbus_live_sync>
          }
          groupBy: {
            args: Prisma.ps_eventbus_live_syncGroupByArgs<ExtArgs>
            result: $Utils.Optional<Ps_eventbus_live_syncGroupByOutputType>[]
          }
          count: {
            args: Prisma.ps_eventbus_live_syncCountArgs<ExtArgs>
            result: $Utils.Optional<Ps_eventbus_live_syncCountAggregateOutputType> | number
          }
        }
      }
      ps_eventbus_type_sync: {
        payload: Prisma.$ps_eventbus_type_syncPayload<ExtArgs>
        fields: Prisma.ps_eventbus_type_syncFieldRefs
        operations: {
          findUnique: {
            args: Prisma.ps_eventbus_type_syncFindUniqueArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_eventbus_type_syncPayload> | null
          }
          findUniqueOrThrow: {
            args: Prisma.ps_eventbus_type_syncFindUniqueOrThrowArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_eventbus_type_syncPayload>
          }
          findFirst: {
            args: Prisma.ps_eventbus_type_syncFindFirstArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_eventbus_type_syncPayload> | null
          }
          findFirstOrThrow: {
            args: Prisma.ps_eventbus_type_syncFindFirstOrThrowArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_eventbus_type_syncPayload>
          }
          findMany: {
            args: Prisma.ps_eventbus_type_syncFindManyArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_eventbus_type_syncPayload>[]
          }
          create: {
            args: Prisma.ps_eventbus_type_syncCreateArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_eventbus_type_syncPayload>
          }
          createMany: {
            args: Prisma.ps_eventbus_type_syncCreateManyArgs<ExtArgs>
            result: BatchPayload
          }
          delete: {
            args: Prisma.ps_eventbus_type_syncDeleteArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_eventbus_type_syncPayload>
          }
          update: {
            args: Prisma.ps_eventbus_type_syncUpdateArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_eventbus_type_syncPayload>
          }
          deleteMany: {
            args: Prisma.ps_eventbus_type_syncDeleteManyArgs<ExtArgs>
            result: BatchPayload
          }
          updateMany: {
            args: Prisma.ps_eventbus_type_syncUpdateManyArgs<ExtArgs>
            result: BatchPayload
          }
          upsert: {
            args: Prisma.ps_eventbus_type_syncUpsertArgs<ExtArgs>
            result: $Utils.PayloadToResult<Prisma.$ps_eventbus_type_syncPayload>
          }
          aggregate: {
            args: Prisma.Ps_eventbus_type_syncAggregateArgs<ExtArgs>
            result: $Utils.Optional<AggregatePs_eventbus_type_sync>
          }
          groupBy: {
            args: Prisma.ps_eventbus_type_syncGroupByArgs<ExtArgs>
            result: $Utils.Optional<Ps_eventbus_type_syncGroupByOutputType>[]
          }
          count: {
            args: Prisma.ps_eventbus_type_syncCountArgs<ExtArgs>
            result: $Utils.Optional<Ps_eventbus_type_syncCountAggregateOutputType> | number
          }
        }
      }
    }
  } & {
    other: {
      payload: any
      operations: {
        $executeRaw: {
          args: [query: TemplateStringsArray | Prisma.Sql, ...values: any[]],
          result: any
        }
        $executeRawUnsafe: {
          args: [query: string, ...values: any[]],
          result: any
        }
        $queryRaw: {
          args: [query: TemplateStringsArray | Prisma.Sql, ...values: any[]],
          result: any
        }
        $queryRawUnsafe: {
          args: [query: string, ...values: any[]],
          result: any
        }
      }
    }
  }
  export const defineExtension: $Extensions.ExtendsHook<"define", Prisma.TypeMapCb, $Extensions.DefaultArgs>
  export type DefaultPrismaClient = PrismaClient
  export type ErrorFormat = 'pretty' | 'colorless' | 'minimal'
  export interface PrismaClientOptions {
    /**
     * Overwrites the datasource url from your schema.prisma file
     */
    datasources?: Datasources
    /**
     * Overwrites the datasource url from your schema.prisma file
     */
    datasourceUrl?: string
    /**
     * @default "colorless"
     */
    errorFormat?: ErrorFormat
    /**
     * @example
     * ```
     * // Defaults to stdout
     * log: ['query', 'info', 'warn', 'error']
     * 
     * // Emit as events
     * log: [
     *   { emit: 'stdout', level: 'query' },
     *   { emit: 'stdout', level: 'info' },
     *   { emit: 'stdout', level: 'warn' }
     *   { emit: 'stdout', level: 'error' }
     * ]
     * ```
     * Read more in our [docs](https://www.prisma.io/docs/reference/tools-and-interfaces/prisma-client/logging#the-log-option).
     */
    log?: (LogLevel | LogDefinition)[]
    /**
     * The default values for transactionOptions
     * maxWait ?= 2000
     * timeout ?= 5000
     */
    transactionOptions?: {
      maxWait?: number
      timeout?: number
      isolationLevel?: Prisma.TransactionIsolationLevel
    }
    /**
     * Global configuration for omitting model fields by default.
     * 
     * @example
     * ```
     * const prisma = new PrismaClient({
     *   omit: {
     *     user: {
     *       password: true
     *     }
     *   }
     * })
     * ```
     */
    omit?: Prisma.GlobalOmitConfig
  }
  export type GlobalOmitConfig = {
    ps_configuration?: ps_configurationOmit
    ps_eventbus_incremental_sync?: ps_eventbus_incremental_syncOmit
    ps_eventbus_job?: ps_eventbus_jobOmit
    ps_eventbus_live_sync?: ps_eventbus_live_syncOmit
    ps_eventbus_type_sync?: ps_eventbus_type_syncOmit
  }

  /* Types for Logging */
  export type LogLevel = 'info' | 'query' | 'warn' | 'error'
  export type LogDefinition = {
    level: LogLevel
    emit: 'stdout' | 'event'
  }

  export type GetLogType<T extends LogLevel | LogDefinition> = T extends LogDefinition ? T['emit'] extends 'event' ? T['level'] : never : never
  export type GetEvents<T extends any> = T extends Array<LogLevel | LogDefinition> ?
    GetLogType<T[0]> | GetLogType<T[1]> | GetLogType<T[2]> | GetLogType<T[3]>
    : never

  export type QueryEvent = {
    timestamp: Date
    query: string
    params: string
    duration: number
    target: string
  }

  export type LogEvent = {
    timestamp: Date
    message: string
    target: string
  }
  /* End Types for Logging */


  export type PrismaAction =
    | 'findUnique'
    | 'findUniqueOrThrow'
    | 'findMany'
    | 'findFirst'
    | 'findFirstOrThrow'
    | 'create'
    | 'createMany'
    | 'createManyAndReturn'
    | 'update'
    | 'updateMany'
    | 'updateManyAndReturn'
    | 'upsert'
    | 'delete'
    | 'deleteMany'
    | 'executeRaw'
    | 'queryRaw'
    | 'aggregate'
    | 'count'
    | 'runCommandRaw'
    | 'findRaw'
    | 'groupBy'

  /**
   * These options are being passed into the middleware as "params"
   */
  export type MiddlewareParams = {
    model?: ModelName
    action: PrismaAction
    args: any
    dataPath: string[]
    runInTransaction: boolean
  }

  /**
   * The `T` type makes sure, that the `return proceed` is not forgotten in the middleware implementation
   */
  export type Middleware<T = any> = (
    params: MiddlewareParams,
    next: (params: MiddlewareParams) => $Utils.JsPromise<T>,
  ) => $Utils.JsPromise<T>

  // tested in getLogLevel.test.ts
  export function getLogLevel(log: Array<LogLevel | LogDefinition>): LogLevel | undefined;

  /**
   * `PrismaClient` proxy available in interactive transactions.
   */
  export type TransactionClient = Omit<Prisma.DefaultPrismaClient, runtime.ITXClientDenyList>

  export type Datasource = {
    url?: string
  }

  /**
   * Count Types
   */



  /**
   * Models
   */

  /**
   * Model ps_configuration
   */

  export type AggregatePs_configuration = {
    _count: Ps_configurationCountAggregateOutputType | null
    _avg: Ps_configurationAvgAggregateOutputType | null
    _sum: Ps_configurationSumAggregateOutputType | null
    _min: Ps_configurationMinAggregateOutputType | null
    _max: Ps_configurationMaxAggregateOutputType | null
  }

  export type Ps_configurationAvgAggregateOutputType = {
    id_configuration: number | null
    id_shop_group: number | null
    id_shop: number | null
  }

  export type Ps_configurationSumAggregateOutputType = {
    id_configuration: number | null
    id_shop_group: number | null
    id_shop: number | null
  }

  export type Ps_configurationMinAggregateOutputType = {
    id_configuration: number | null
    id_shop_group: number | null
    id_shop: number | null
    name: string | null
    value: string | null
    date_add: Date | null
    date_upd: Date | null
  }

  export type Ps_configurationMaxAggregateOutputType = {
    id_configuration: number | null
    id_shop_group: number | null
    id_shop: number | null
    name: string | null
    value: string | null
    date_add: Date | null
    date_upd: Date | null
  }

  export type Ps_configurationCountAggregateOutputType = {
    id_configuration: number
    id_shop_group: number
    id_shop: number
    name: number
    value: number
    date_add: number
    date_upd: number
    _all: number
  }


  export type Ps_configurationAvgAggregateInputType = {
    id_configuration?: true
    id_shop_group?: true
    id_shop?: true
  }

  export type Ps_configurationSumAggregateInputType = {
    id_configuration?: true
    id_shop_group?: true
    id_shop?: true
  }

  export type Ps_configurationMinAggregateInputType = {
    id_configuration?: true
    id_shop_group?: true
    id_shop?: true
    name?: true
    value?: true
    date_add?: true
    date_upd?: true
  }

  export type Ps_configurationMaxAggregateInputType = {
    id_configuration?: true
    id_shop_group?: true
    id_shop?: true
    name?: true
    value?: true
    date_add?: true
    date_upd?: true
  }

  export type Ps_configurationCountAggregateInputType = {
    id_configuration?: true
    id_shop_group?: true
    id_shop?: true
    name?: true
    value?: true
    date_add?: true
    date_upd?: true
    _all?: true
  }

  export type Ps_configurationAggregateArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Filter which ps_configuration to aggregate.
     */
    where?: ps_configurationWhereInput
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/sorting Sorting Docs}
     * 
     * Determine the order of ps_configurations to fetch.
     */
    orderBy?: ps_configurationOrderByWithRelationInput | ps_configurationOrderByWithRelationInput[]
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination#cursor-based-pagination Cursor Docs}
     * 
     * Sets the start position
     */
    cursor?: ps_configurationWhereUniqueInput
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination Pagination Docs}
     * 
     * Take `±n` ps_configurations from the position of the cursor.
     */
    take?: number
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination Pagination Docs}
     * 
     * Skip the first `n` ps_configurations.
     */
    skip?: number
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/aggregations Aggregation Docs}
     * 
     * Count returned ps_configurations
    **/
    _count?: true | Ps_configurationCountAggregateInputType
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/aggregations Aggregation Docs}
     * 
     * Select which fields to average
    **/
    _avg?: Ps_configurationAvgAggregateInputType
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/aggregations Aggregation Docs}
     * 
     * Select which fields to sum
    **/
    _sum?: Ps_configurationSumAggregateInputType
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/aggregations Aggregation Docs}
     * 
     * Select which fields to find the minimum value
    **/
    _min?: Ps_configurationMinAggregateInputType
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/aggregations Aggregation Docs}
     * 
     * Select which fields to find the maximum value
    **/
    _max?: Ps_configurationMaxAggregateInputType
  }

  export type GetPs_configurationAggregateType<T extends Ps_configurationAggregateArgs> = {
        [P in keyof T & keyof AggregatePs_configuration]: P extends '_count' | 'count'
      ? T[P] extends true
        ? number
        : GetScalarType<T[P], AggregatePs_configuration[P]>
      : GetScalarType<T[P], AggregatePs_configuration[P]>
  }




  export type ps_configurationGroupByArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    where?: ps_configurationWhereInput
    orderBy?: ps_configurationOrderByWithAggregationInput | ps_configurationOrderByWithAggregationInput[]
    by: Ps_configurationScalarFieldEnum[] | Ps_configurationScalarFieldEnum
    having?: ps_configurationScalarWhereWithAggregatesInput
    take?: number
    skip?: number
    _count?: Ps_configurationCountAggregateInputType | true
    _avg?: Ps_configurationAvgAggregateInputType
    _sum?: Ps_configurationSumAggregateInputType
    _min?: Ps_configurationMinAggregateInputType
    _max?: Ps_configurationMaxAggregateInputType
  }

  export type Ps_configurationGroupByOutputType = {
    id_configuration: number
    id_shop_group: number | null
    id_shop: number | null
    name: string
    value: string | null
    date_add: Date
    date_upd: Date
    _count: Ps_configurationCountAggregateOutputType | null
    _avg: Ps_configurationAvgAggregateOutputType | null
    _sum: Ps_configurationSumAggregateOutputType | null
    _min: Ps_configurationMinAggregateOutputType | null
    _max: Ps_configurationMaxAggregateOutputType | null
  }

  type GetPs_configurationGroupByPayload<T extends ps_configurationGroupByArgs> = Prisma.PrismaPromise<
    Array<
      PickEnumerable<Ps_configurationGroupByOutputType, T['by']> &
        {
          [P in ((keyof T) & (keyof Ps_configurationGroupByOutputType))]: P extends '_count'
            ? T[P] extends boolean
              ? number
              : GetScalarType<T[P], Ps_configurationGroupByOutputType[P]>
            : GetScalarType<T[P], Ps_configurationGroupByOutputType[P]>
        }
      >
    >


  export type ps_configurationSelect<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = $Extensions.GetSelect<{
    id_configuration?: boolean
    id_shop_group?: boolean
    id_shop?: boolean
    name?: boolean
    value?: boolean
    date_add?: boolean
    date_upd?: boolean
  }, ExtArgs["result"]["ps_configuration"]>



  export type ps_configurationSelectScalar = {
    id_configuration?: boolean
    id_shop_group?: boolean
    id_shop?: boolean
    name?: boolean
    value?: boolean
    date_add?: boolean
    date_upd?: boolean
  }

  export type ps_configurationOmit<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = $Extensions.GetOmit<"id_configuration" | "id_shop_group" | "id_shop" | "name" | "value" | "date_add" | "date_upd", ExtArgs["result"]["ps_configuration"]>

  export type $ps_configurationPayload<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    name: "ps_configuration"
    objects: {}
    scalars: $Extensions.GetPayloadResult<{
      id_configuration: number
      id_shop_group: number | null
      id_shop: number | null
      name: string
      value: string | null
      date_add: Date
      date_upd: Date
    }, ExtArgs["result"]["ps_configuration"]>
    composites: {}
  }

  type ps_configurationGetPayload<S extends boolean | null | undefined | ps_configurationDefaultArgs> = $Result.GetResult<Prisma.$ps_configurationPayload, S>

  type ps_configurationCountArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> =
    Omit<ps_configurationFindManyArgs, 'select' | 'include' | 'distinct' | 'omit'> & {
      select?: Ps_configurationCountAggregateInputType | true
    }

  export interface ps_configurationDelegate<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs, GlobalOmitOptions = {}> {
    [K: symbol]: { types: Prisma.TypeMap<ExtArgs>['model']['ps_configuration'], meta: { name: 'ps_configuration' } }
    /**
     * Find zero or one Ps_configuration that matches the filter.
     * @param {ps_configurationFindUniqueArgs} args - Arguments to find a Ps_configuration
     * @example
     * // Get one Ps_configuration
     * const ps_configuration = await prisma.ps_configuration.findUnique({
     *   where: {
     *     // ... provide filter here
     *   }
     * })
     */
    findUnique<T extends ps_configurationFindUniqueArgs>(args: SelectSubset<T, ps_configurationFindUniqueArgs<ExtArgs>>): Prisma__ps_configurationClient<$Result.GetResult<Prisma.$ps_configurationPayload<ExtArgs>, T, "findUnique", GlobalOmitOptions> | null, null, ExtArgs, GlobalOmitOptions>

    /**
     * Find one Ps_configuration that matches the filter or throw an error with `error.code='P2025'`
     * if no matches were found.
     * @param {ps_configurationFindUniqueOrThrowArgs} args - Arguments to find a Ps_configuration
     * @example
     * // Get one Ps_configuration
     * const ps_configuration = await prisma.ps_configuration.findUniqueOrThrow({
     *   where: {
     *     // ... provide filter here
     *   }
     * })
     */
    findUniqueOrThrow<T extends ps_configurationFindUniqueOrThrowArgs>(args: SelectSubset<T, ps_configurationFindUniqueOrThrowArgs<ExtArgs>>): Prisma__ps_configurationClient<$Result.GetResult<Prisma.$ps_configurationPayload<ExtArgs>, T, "findUniqueOrThrow", GlobalOmitOptions>, never, ExtArgs, GlobalOmitOptions>

    /**
     * Find the first Ps_configuration that matches the filter.
     * Note, that providing `undefined` is treated as the value not being there.
     * Read more here: https://pris.ly/d/null-undefined
     * @param {ps_configurationFindFirstArgs} args - Arguments to find a Ps_configuration
     * @example
     * // Get one Ps_configuration
     * const ps_configuration = await prisma.ps_configuration.findFirst({
     *   where: {
     *     // ... provide filter here
     *   }
     * })
     */
    findFirst<T extends ps_configurationFindFirstArgs>(args?: SelectSubset<T, ps_configurationFindFirstArgs<ExtArgs>>): Prisma__ps_configurationClient<$Result.GetResult<Prisma.$ps_configurationPayload<ExtArgs>, T, "findFirst", GlobalOmitOptions> | null, null, ExtArgs, GlobalOmitOptions>

    /**
     * Find the first Ps_configuration that matches the filter or
     * throw `PrismaKnownClientError` with `P2025` code if no matches were found.
     * Note, that providing `undefined` is treated as the value not being there.
     * Read more here: https://pris.ly/d/null-undefined
     * @param {ps_configurationFindFirstOrThrowArgs} args - Arguments to find a Ps_configuration
     * @example
     * // Get one Ps_configuration
     * const ps_configuration = await prisma.ps_configuration.findFirstOrThrow({
     *   where: {
     *     // ... provide filter here
     *   }
     * })
     */
    findFirstOrThrow<T extends ps_configurationFindFirstOrThrowArgs>(args?: SelectSubset<T, ps_configurationFindFirstOrThrowArgs<ExtArgs>>): Prisma__ps_configurationClient<$Result.GetResult<Prisma.$ps_configurationPayload<ExtArgs>, T, "findFirstOrThrow", GlobalOmitOptions>, never, ExtArgs, GlobalOmitOptions>

    /**
     * Find zero or more Ps_configurations that matches the filter.
     * Note, that providing `undefined` is treated as the value not being there.
     * Read more here: https://pris.ly/d/null-undefined
     * @param {ps_configurationFindManyArgs} args - Arguments to filter and select certain fields only.
     * @example
     * // Get all Ps_configurations
     * const ps_configurations = await prisma.ps_configuration.findMany()
     * 
     * // Get first 10 Ps_configurations
     * const ps_configurations = await prisma.ps_configuration.findMany({ take: 10 })
     * 
     * // Only select the `id_configuration`
     * const ps_configurationWithId_configurationOnly = await prisma.ps_configuration.findMany({ select: { id_configuration: true } })
     * 
     */
    findMany<T extends ps_configurationFindManyArgs>(args?: SelectSubset<T, ps_configurationFindManyArgs<ExtArgs>>): Prisma.PrismaPromise<$Result.GetResult<Prisma.$ps_configurationPayload<ExtArgs>, T, "findMany", GlobalOmitOptions>>

    /**
     * Create a Ps_configuration.
     * @param {ps_configurationCreateArgs} args - Arguments to create a Ps_configuration.
     * @example
     * // Create one Ps_configuration
     * const Ps_configuration = await prisma.ps_configuration.create({
     *   data: {
     *     // ... data to create a Ps_configuration
     *   }
     * })
     * 
     */
    create<T extends ps_configurationCreateArgs>(args: SelectSubset<T, ps_configurationCreateArgs<ExtArgs>>): Prisma__ps_configurationClient<$Result.GetResult<Prisma.$ps_configurationPayload<ExtArgs>, T, "create", GlobalOmitOptions>, never, ExtArgs, GlobalOmitOptions>

    /**
     * Create many Ps_configurations.
     * @param {ps_configurationCreateManyArgs} args - Arguments to create many Ps_configurations.
     * @example
     * // Create many Ps_configurations
     * const ps_configuration = await prisma.ps_configuration.createMany({
     *   data: [
     *     // ... provide data here
     *   ]
     * })
     *     
     */
    createMany<T extends ps_configurationCreateManyArgs>(args?: SelectSubset<T, ps_configurationCreateManyArgs<ExtArgs>>): Prisma.PrismaPromise<BatchPayload>

    /**
     * Delete a Ps_configuration.
     * @param {ps_configurationDeleteArgs} args - Arguments to delete one Ps_configuration.
     * @example
     * // Delete one Ps_configuration
     * const Ps_configuration = await prisma.ps_configuration.delete({
     *   where: {
     *     // ... filter to delete one Ps_configuration
     *   }
     * })
     * 
     */
    delete<T extends ps_configurationDeleteArgs>(args: SelectSubset<T, ps_configurationDeleteArgs<ExtArgs>>): Prisma__ps_configurationClient<$Result.GetResult<Prisma.$ps_configurationPayload<ExtArgs>, T, "delete", GlobalOmitOptions>, never, ExtArgs, GlobalOmitOptions>

    /**
     * Update one Ps_configuration.
     * @param {ps_configurationUpdateArgs} args - Arguments to update one Ps_configuration.
     * @example
     * // Update one Ps_configuration
     * const ps_configuration = await prisma.ps_configuration.update({
     *   where: {
     *     // ... provide filter here
     *   },
     *   data: {
     *     // ... provide data here
     *   }
     * })
     * 
     */
    update<T extends ps_configurationUpdateArgs>(args: SelectSubset<T, ps_configurationUpdateArgs<ExtArgs>>): Prisma__ps_configurationClient<$Result.GetResult<Prisma.$ps_configurationPayload<ExtArgs>, T, "update", GlobalOmitOptions>, never, ExtArgs, GlobalOmitOptions>

    /**
     * Delete zero or more Ps_configurations.
     * @param {ps_configurationDeleteManyArgs} args - Arguments to filter Ps_configurations to delete.
     * @example
     * // Delete a few Ps_configurations
     * const { count } = await prisma.ps_configuration.deleteMany({
     *   where: {
     *     // ... provide filter here
     *   }
     * })
     * 
     */
    deleteMany<T extends ps_configurationDeleteManyArgs>(args?: SelectSubset<T, ps_configurationDeleteManyArgs<ExtArgs>>): Prisma.PrismaPromise<BatchPayload>

    /**
     * Update zero or more Ps_configurations.
     * Note, that providing `undefined` is treated as the value not being there.
     * Read more here: https://pris.ly/d/null-undefined
     * @param {ps_configurationUpdateManyArgs} args - Arguments to update one or more rows.
     * @example
     * // Update many Ps_configurations
     * const ps_configuration = await prisma.ps_configuration.updateMany({
     *   where: {
     *     // ... provide filter here
     *   },
     *   data: {
     *     // ... provide data here
     *   }
     * })
     * 
     */
    updateMany<T extends ps_configurationUpdateManyArgs>(args: SelectSubset<T, ps_configurationUpdateManyArgs<ExtArgs>>): Prisma.PrismaPromise<BatchPayload>

    /**
     * Create or update one Ps_configuration.
     * @param {ps_configurationUpsertArgs} args - Arguments to update or create a Ps_configuration.
     * @example
     * // Update or create a Ps_configuration
     * const ps_configuration = await prisma.ps_configuration.upsert({
     *   create: {
     *     // ... data to create a Ps_configuration
     *   },
     *   update: {
     *     // ... in case it already exists, update
     *   },
     *   where: {
     *     // ... the filter for the Ps_configuration we want to update
     *   }
     * })
     */
    upsert<T extends ps_configurationUpsertArgs>(args: SelectSubset<T, ps_configurationUpsertArgs<ExtArgs>>): Prisma__ps_configurationClient<$Result.GetResult<Prisma.$ps_configurationPayload<ExtArgs>, T, "upsert", GlobalOmitOptions>, never, ExtArgs, GlobalOmitOptions>


    /**
     * Count the number of Ps_configurations.
     * Note, that providing `undefined` is treated as the value not being there.
     * Read more here: https://pris.ly/d/null-undefined
     * @param {ps_configurationCountArgs} args - Arguments to filter Ps_configurations to count.
     * @example
     * // Count the number of Ps_configurations
     * const count = await prisma.ps_configuration.count({
     *   where: {
     *     // ... the filter for the Ps_configurations we want to count
     *   }
     * })
    **/
    count<T extends ps_configurationCountArgs>(
      args?: Subset<T, ps_configurationCountArgs>,
    ): Prisma.PrismaPromise<
      T extends $Utils.Record<'select', any>
        ? T['select'] extends true
          ? number
          : GetScalarType<T['select'], Ps_configurationCountAggregateOutputType>
        : number
    >

    /**
     * Allows you to perform aggregations operations on a Ps_configuration.
     * Note, that providing `undefined` is treated as the value not being there.
     * Read more here: https://pris.ly/d/null-undefined
     * @param {Ps_configurationAggregateArgs} args - Select which aggregations you would like to apply and on what fields.
     * @example
     * // Ordered by age ascending
     * // Where email contains prisma.io
     * // Limited to the 10 users
     * const aggregations = await prisma.user.aggregate({
     *   _avg: {
     *     age: true,
     *   },
     *   where: {
     *     email: {
     *       contains: "prisma.io",
     *     },
     *   },
     *   orderBy: {
     *     age: "asc",
     *   },
     *   take: 10,
     * })
    **/
    aggregate<T extends Ps_configurationAggregateArgs>(args: Subset<T, Ps_configurationAggregateArgs>): Prisma.PrismaPromise<GetPs_configurationAggregateType<T>>

    /**
     * Group by Ps_configuration.
     * Note, that providing `undefined` is treated as the value not being there.
     * Read more here: https://pris.ly/d/null-undefined
     * @param {ps_configurationGroupByArgs} args - Group by arguments.
     * @example
     * // Group by city, order by createdAt, get count
     * const result = await prisma.user.groupBy({
     *   by: ['city', 'createdAt'],
     *   orderBy: {
     *     createdAt: true
     *   },
     *   _count: {
     *     _all: true
     *   },
     * })
     * 
    **/
    groupBy<
      T extends ps_configurationGroupByArgs,
      HasSelectOrTake extends Or<
        Extends<'skip', Keys<T>>,
        Extends<'take', Keys<T>>
      >,
      OrderByArg extends True extends HasSelectOrTake
        ? { orderBy: ps_configurationGroupByArgs['orderBy'] }
        : { orderBy?: ps_configurationGroupByArgs['orderBy'] },
      OrderFields extends ExcludeUnderscoreKeys<Keys<MaybeTupleToUnion<T['orderBy']>>>,
      ByFields extends MaybeTupleToUnion<T['by']>,
      ByValid extends Has<ByFields, OrderFields>,
      HavingFields extends GetHavingFields<T['having']>,
      HavingValid extends Has<ByFields, HavingFields>,
      ByEmpty extends T['by'] extends never[] ? True : False,
      InputErrors extends ByEmpty extends True
      ? `Error: "by" must not be empty.`
      : HavingValid extends False
      ? {
          [P in HavingFields]: P extends ByFields
            ? never
            : P extends string
            ? `Error: Field "${P}" used in "having" needs to be provided in "by".`
            : [
                Error,
                'Field ',
                P,
                ` in "having" needs to be provided in "by"`,
              ]
        }[HavingFields]
      : 'take' extends Keys<T>
      ? 'orderBy' extends Keys<T>
        ? ByValid extends True
          ? {}
          : {
              [P in OrderFields]: P extends ByFields
                ? never
                : `Error: Field "${P}" in "orderBy" needs to be provided in "by"`
            }[OrderFields]
        : 'Error: If you provide "take", you also need to provide "orderBy"'
      : 'skip' extends Keys<T>
      ? 'orderBy' extends Keys<T>
        ? ByValid extends True
          ? {}
          : {
              [P in OrderFields]: P extends ByFields
                ? never
                : `Error: Field "${P}" in "orderBy" needs to be provided in "by"`
            }[OrderFields]
        : 'Error: If you provide "skip", you also need to provide "orderBy"'
      : ByValid extends True
      ? {}
      : {
          [P in OrderFields]: P extends ByFields
            ? never
            : `Error: Field "${P}" in "orderBy" needs to be provided in "by"`
        }[OrderFields]
    >(args: SubsetIntersection<T, ps_configurationGroupByArgs, OrderByArg> & InputErrors): {} extends InputErrors ? GetPs_configurationGroupByPayload<T> : Prisma.PrismaPromise<InputErrors>
  /**
   * Fields of the ps_configuration model
   */
  readonly fields: ps_configurationFieldRefs;
  }

  /**
   * The delegate class that acts as a "Promise-like" for ps_configuration.
   * Why is this prefixed with `Prisma__`?
   * Because we want to prevent naming conflicts as mentioned in
   * https://github.com/prisma/prisma-client-js/issues/707
   */
  export interface Prisma__ps_configurationClient<T, Null = never, ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs, GlobalOmitOptions = {}> extends Prisma.PrismaPromise<T> {
    readonly [Symbol.toStringTag]: "PrismaPromise"
    /**
     * Attaches callbacks for the resolution and/or rejection of the Promise.
     * @param onfulfilled The callback to execute when the Promise is resolved.
     * @param onrejected The callback to execute when the Promise is rejected.
     * @returns A Promise for the completion of which ever callback is executed.
     */
    then<TResult1 = T, TResult2 = never>(onfulfilled?: ((value: T) => TResult1 | PromiseLike<TResult1>) | undefined | null, onrejected?: ((reason: any) => TResult2 | PromiseLike<TResult2>) | undefined | null): $Utils.JsPromise<TResult1 | TResult2>
    /**
     * Attaches a callback for only the rejection of the Promise.
     * @param onrejected The callback to execute when the Promise is rejected.
     * @returns A Promise for the completion of the callback.
     */
    catch<TResult = never>(onrejected?: ((reason: any) => TResult | PromiseLike<TResult>) | undefined | null): $Utils.JsPromise<T | TResult>
    /**
     * Attaches a callback that is invoked when the Promise is settled (fulfilled or rejected). The
     * resolved value cannot be modified from the callback.
     * @param onfinally The callback to execute when the Promise is settled (fulfilled or rejected).
     * @returns A Promise for the completion of the callback.
     */
    finally(onfinally?: (() => void) | undefined | null): $Utils.JsPromise<T>
  }




  /**
   * Fields of the ps_configuration model
   */
  interface ps_configurationFieldRefs {
    readonly id_configuration: FieldRef<"ps_configuration", 'Int'>
    readonly id_shop_group: FieldRef<"ps_configuration", 'Int'>
    readonly id_shop: FieldRef<"ps_configuration", 'Int'>
    readonly name: FieldRef<"ps_configuration", 'String'>
    readonly value: FieldRef<"ps_configuration", 'String'>
    readonly date_add: FieldRef<"ps_configuration", 'DateTime'>
    readonly date_upd: FieldRef<"ps_configuration", 'DateTime'>
  }
    

  // Custom InputTypes
  /**
   * ps_configuration findUnique
   */
  export type ps_configurationFindUniqueArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_configuration
     */
    select?: ps_configurationSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_configuration
     */
    omit?: ps_configurationOmit<ExtArgs> | null
    /**
     * Filter, which ps_configuration to fetch.
     */
    where: ps_configurationWhereUniqueInput
  }

  /**
   * ps_configuration findUniqueOrThrow
   */
  export type ps_configurationFindUniqueOrThrowArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_configuration
     */
    select?: ps_configurationSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_configuration
     */
    omit?: ps_configurationOmit<ExtArgs> | null
    /**
     * Filter, which ps_configuration to fetch.
     */
    where: ps_configurationWhereUniqueInput
  }

  /**
   * ps_configuration findFirst
   */
  export type ps_configurationFindFirstArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_configuration
     */
    select?: ps_configurationSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_configuration
     */
    omit?: ps_configurationOmit<ExtArgs> | null
    /**
     * Filter, which ps_configuration to fetch.
     */
    where?: ps_configurationWhereInput
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/sorting Sorting Docs}
     * 
     * Determine the order of ps_configurations to fetch.
     */
    orderBy?: ps_configurationOrderByWithRelationInput | ps_configurationOrderByWithRelationInput[]
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination#cursor-based-pagination Cursor Docs}
     * 
     * Sets the position for searching for ps_configurations.
     */
    cursor?: ps_configurationWhereUniqueInput
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination Pagination Docs}
     * 
     * Take `±n` ps_configurations from the position of the cursor.
     */
    take?: number
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination Pagination Docs}
     * 
     * Skip the first `n` ps_configurations.
     */
    skip?: number
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/distinct Distinct Docs}
     * 
     * Filter by unique combinations of ps_configurations.
     */
    distinct?: Ps_configurationScalarFieldEnum | Ps_configurationScalarFieldEnum[]
  }

  /**
   * ps_configuration findFirstOrThrow
   */
  export type ps_configurationFindFirstOrThrowArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_configuration
     */
    select?: ps_configurationSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_configuration
     */
    omit?: ps_configurationOmit<ExtArgs> | null
    /**
     * Filter, which ps_configuration to fetch.
     */
    where?: ps_configurationWhereInput
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/sorting Sorting Docs}
     * 
     * Determine the order of ps_configurations to fetch.
     */
    orderBy?: ps_configurationOrderByWithRelationInput | ps_configurationOrderByWithRelationInput[]
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination#cursor-based-pagination Cursor Docs}
     * 
     * Sets the position for searching for ps_configurations.
     */
    cursor?: ps_configurationWhereUniqueInput
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination Pagination Docs}
     * 
     * Take `±n` ps_configurations from the position of the cursor.
     */
    take?: number
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination Pagination Docs}
     * 
     * Skip the first `n` ps_configurations.
     */
    skip?: number
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/distinct Distinct Docs}
     * 
     * Filter by unique combinations of ps_configurations.
     */
    distinct?: Ps_configurationScalarFieldEnum | Ps_configurationScalarFieldEnum[]
  }

  /**
   * ps_configuration findMany
   */
  export type ps_configurationFindManyArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_configuration
     */
    select?: ps_configurationSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_configuration
     */
    omit?: ps_configurationOmit<ExtArgs> | null
    /**
     * Filter, which ps_configurations to fetch.
     */
    where?: ps_configurationWhereInput
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/sorting Sorting Docs}
     * 
     * Determine the order of ps_configurations to fetch.
     */
    orderBy?: ps_configurationOrderByWithRelationInput | ps_configurationOrderByWithRelationInput[]
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination#cursor-based-pagination Cursor Docs}
     * 
     * Sets the position for listing ps_configurations.
     */
    cursor?: ps_configurationWhereUniqueInput
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination Pagination Docs}
     * 
     * Take `±n` ps_configurations from the position of the cursor.
     */
    take?: number
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination Pagination Docs}
     * 
     * Skip the first `n` ps_configurations.
     */
    skip?: number
    distinct?: Ps_configurationScalarFieldEnum | Ps_configurationScalarFieldEnum[]
  }

  /**
   * ps_configuration create
   */
  export type ps_configurationCreateArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_configuration
     */
    select?: ps_configurationSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_configuration
     */
    omit?: ps_configurationOmit<ExtArgs> | null
    /**
     * The data needed to create a ps_configuration.
     */
    data: XOR<ps_configurationCreateInput, ps_configurationUncheckedCreateInput>
  }

  /**
   * ps_configuration createMany
   */
  export type ps_configurationCreateManyArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * The data used to create many ps_configurations.
     */
    data: ps_configurationCreateManyInput | ps_configurationCreateManyInput[]
    skipDuplicates?: boolean
  }

  /**
   * ps_configuration update
   */
  export type ps_configurationUpdateArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_configuration
     */
    select?: ps_configurationSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_configuration
     */
    omit?: ps_configurationOmit<ExtArgs> | null
    /**
     * The data needed to update a ps_configuration.
     */
    data: XOR<ps_configurationUpdateInput, ps_configurationUncheckedUpdateInput>
    /**
     * Choose, which ps_configuration to update.
     */
    where: ps_configurationWhereUniqueInput
  }

  /**
   * ps_configuration updateMany
   */
  export type ps_configurationUpdateManyArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * The data used to update ps_configurations.
     */
    data: XOR<ps_configurationUpdateManyMutationInput, ps_configurationUncheckedUpdateManyInput>
    /**
     * Filter which ps_configurations to update
     */
    where?: ps_configurationWhereInput
    /**
     * Limit how many ps_configurations to update.
     */
    limit?: number
  }

  /**
   * ps_configuration upsert
   */
  export type ps_configurationUpsertArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_configuration
     */
    select?: ps_configurationSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_configuration
     */
    omit?: ps_configurationOmit<ExtArgs> | null
    /**
     * The filter to search for the ps_configuration to update in case it exists.
     */
    where: ps_configurationWhereUniqueInput
    /**
     * In case the ps_configuration found by the `where` argument doesn't exist, create a new ps_configuration with this data.
     */
    create: XOR<ps_configurationCreateInput, ps_configurationUncheckedCreateInput>
    /**
     * In case the ps_configuration was found with the provided `where` argument, update it with this data.
     */
    update: XOR<ps_configurationUpdateInput, ps_configurationUncheckedUpdateInput>
  }

  /**
   * ps_configuration delete
   */
  export type ps_configurationDeleteArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_configuration
     */
    select?: ps_configurationSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_configuration
     */
    omit?: ps_configurationOmit<ExtArgs> | null
    /**
     * Filter which ps_configuration to delete.
     */
    where: ps_configurationWhereUniqueInput
  }

  /**
   * ps_configuration deleteMany
   */
  export type ps_configurationDeleteManyArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Filter which ps_configurations to delete
     */
    where?: ps_configurationWhereInput
    /**
     * Limit how many ps_configurations to delete.
     */
    limit?: number
  }

  /**
   * ps_configuration without action
   */
  export type ps_configurationDefaultArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_configuration
     */
    select?: ps_configurationSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_configuration
     */
    omit?: ps_configurationOmit<ExtArgs> | null
  }


  /**
   * Model ps_eventbus_incremental_sync
   */

  export type AggregatePs_eventbus_incremental_sync = {
    _count: Ps_eventbus_incremental_syncCountAggregateOutputType | null
    _avg: Ps_eventbus_incremental_syncAvgAggregateOutputType | null
    _sum: Ps_eventbus_incremental_syncSumAggregateOutputType | null
    _min: Ps_eventbus_incremental_syncMinAggregateOutputType | null
    _max: Ps_eventbus_incremental_syncMaxAggregateOutputType | null
  }

  export type Ps_eventbus_incremental_syncAvgAggregateOutputType = {
    id_shop: number | null
  }

  export type Ps_eventbus_incremental_syncSumAggregateOutputType = {
    id_shop: number | null
  }

  export type Ps_eventbus_incremental_syncMinAggregateOutputType = {
    type: string | null
    action: string | null
    id_object: string | null
    id_shop: number | null
    lang_iso: string | null
    created_at: Date | null
  }

  export type Ps_eventbus_incremental_syncMaxAggregateOutputType = {
    type: string | null
    action: string | null
    id_object: string | null
    id_shop: number | null
    lang_iso: string | null
    created_at: Date | null
  }

  export type Ps_eventbus_incremental_syncCountAggregateOutputType = {
    type: number
    action: number
    id_object: number
    id_shop: number
    lang_iso: number
    created_at: number
    _all: number
  }


  export type Ps_eventbus_incremental_syncAvgAggregateInputType = {
    id_shop?: true
  }

  export type Ps_eventbus_incremental_syncSumAggregateInputType = {
    id_shop?: true
  }

  export type Ps_eventbus_incremental_syncMinAggregateInputType = {
    type?: true
    action?: true
    id_object?: true
    id_shop?: true
    lang_iso?: true
    created_at?: true
  }

  export type Ps_eventbus_incremental_syncMaxAggregateInputType = {
    type?: true
    action?: true
    id_object?: true
    id_shop?: true
    lang_iso?: true
    created_at?: true
  }

  export type Ps_eventbus_incremental_syncCountAggregateInputType = {
    type?: true
    action?: true
    id_object?: true
    id_shop?: true
    lang_iso?: true
    created_at?: true
    _all?: true
  }

  export type Ps_eventbus_incremental_syncAggregateArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Filter which ps_eventbus_incremental_sync to aggregate.
     */
    where?: ps_eventbus_incremental_syncWhereInput
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/sorting Sorting Docs}
     * 
     * Determine the order of ps_eventbus_incremental_syncs to fetch.
     */
    orderBy?: ps_eventbus_incremental_syncOrderByWithRelationInput | ps_eventbus_incremental_syncOrderByWithRelationInput[]
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination#cursor-based-pagination Cursor Docs}
     * 
     * Sets the start position
     */
    cursor?: ps_eventbus_incremental_syncWhereUniqueInput
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination Pagination Docs}
     * 
     * Take `±n` ps_eventbus_incremental_syncs from the position of the cursor.
     */
    take?: number
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination Pagination Docs}
     * 
     * Skip the first `n` ps_eventbus_incremental_syncs.
     */
    skip?: number
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/aggregations Aggregation Docs}
     * 
     * Count returned ps_eventbus_incremental_syncs
    **/
    _count?: true | Ps_eventbus_incremental_syncCountAggregateInputType
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/aggregations Aggregation Docs}
     * 
     * Select which fields to average
    **/
    _avg?: Ps_eventbus_incremental_syncAvgAggregateInputType
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/aggregations Aggregation Docs}
     * 
     * Select which fields to sum
    **/
    _sum?: Ps_eventbus_incremental_syncSumAggregateInputType
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/aggregations Aggregation Docs}
     * 
     * Select which fields to find the minimum value
    **/
    _min?: Ps_eventbus_incremental_syncMinAggregateInputType
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/aggregations Aggregation Docs}
     * 
     * Select which fields to find the maximum value
    **/
    _max?: Ps_eventbus_incremental_syncMaxAggregateInputType
  }

  export type GetPs_eventbus_incremental_syncAggregateType<T extends Ps_eventbus_incremental_syncAggregateArgs> = {
        [P in keyof T & keyof AggregatePs_eventbus_incremental_sync]: P extends '_count' | 'count'
      ? T[P] extends true
        ? number
        : GetScalarType<T[P], AggregatePs_eventbus_incremental_sync[P]>
      : GetScalarType<T[P], AggregatePs_eventbus_incremental_sync[P]>
  }




  export type ps_eventbus_incremental_syncGroupByArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    where?: ps_eventbus_incremental_syncWhereInput
    orderBy?: ps_eventbus_incremental_syncOrderByWithAggregationInput | ps_eventbus_incremental_syncOrderByWithAggregationInput[]
    by: Ps_eventbus_incremental_syncScalarFieldEnum[] | Ps_eventbus_incremental_syncScalarFieldEnum
    having?: ps_eventbus_incremental_syncScalarWhereWithAggregatesInput
    take?: number
    skip?: number
    _count?: Ps_eventbus_incremental_syncCountAggregateInputType | true
    _avg?: Ps_eventbus_incremental_syncAvgAggregateInputType
    _sum?: Ps_eventbus_incremental_syncSumAggregateInputType
    _min?: Ps_eventbus_incremental_syncMinAggregateInputType
    _max?: Ps_eventbus_incremental_syncMaxAggregateInputType
  }

  export type Ps_eventbus_incremental_syncGroupByOutputType = {
    type: string
    action: string
    id_object: string
    id_shop: number
    lang_iso: string
    created_at: Date
    _count: Ps_eventbus_incremental_syncCountAggregateOutputType | null
    _avg: Ps_eventbus_incremental_syncAvgAggregateOutputType | null
    _sum: Ps_eventbus_incremental_syncSumAggregateOutputType | null
    _min: Ps_eventbus_incremental_syncMinAggregateOutputType | null
    _max: Ps_eventbus_incremental_syncMaxAggregateOutputType | null
  }

  type GetPs_eventbus_incremental_syncGroupByPayload<T extends ps_eventbus_incremental_syncGroupByArgs> = Prisma.PrismaPromise<
    Array<
      PickEnumerable<Ps_eventbus_incremental_syncGroupByOutputType, T['by']> &
        {
          [P in ((keyof T) & (keyof Ps_eventbus_incremental_syncGroupByOutputType))]: P extends '_count'
            ? T[P] extends boolean
              ? number
              : GetScalarType<T[P], Ps_eventbus_incremental_syncGroupByOutputType[P]>
            : GetScalarType<T[P], Ps_eventbus_incremental_syncGroupByOutputType[P]>
        }
      >
    >


  export type ps_eventbus_incremental_syncSelect<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = $Extensions.GetSelect<{
    type?: boolean
    action?: boolean
    id_object?: boolean
    id_shop?: boolean
    lang_iso?: boolean
    created_at?: boolean
  }, ExtArgs["result"]["ps_eventbus_incremental_sync"]>



  export type ps_eventbus_incremental_syncSelectScalar = {
    type?: boolean
    action?: boolean
    id_object?: boolean
    id_shop?: boolean
    lang_iso?: boolean
    created_at?: boolean
  }

  export type ps_eventbus_incremental_syncOmit<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = $Extensions.GetOmit<"type" | "action" | "id_object" | "id_shop" | "lang_iso" | "created_at", ExtArgs["result"]["ps_eventbus_incremental_sync"]>

  export type $ps_eventbus_incremental_syncPayload<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    name: "ps_eventbus_incremental_sync"
    objects: {}
    scalars: $Extensions.GetPayloadResult<{
      type: string
      action: string
      id_object: string
      id_shop: number
      lang_iso: string
      created_at: Date
    }, ExtArgs["result"]["ps_eventbus_incremental_sync"]>
    composites: {}
  }

  type ps_eventbus_incremental_syncGetPayload<S extends boolean | null | undefined | ps_eventbus_incremental_syncDefaultArgs> = $Result.GetResult<Prisma.$ps_eventbus_incremental_syncPayload, S>

  type ps_eventbus_incremental_syncCountArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> =
    Omit<ps_eventbus_incremental_syncFindManyArgs, 'select' | 'include' | 'distinct' | 'omit'> & {
      select?: Ps_eventbus_incremental_syncCountAggregateInputType | true
    }

  export interface ps_eventbus_incremental_syncDelegate<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs, GlobalOmitOptions = {}> {
    [K: symbol]: { types: Prisma.TypeMap<ExtArgs>['model']['ps_eventbus_incremental_sync'], meta: { name: 'ps_eventbus_incremental_sync' } }
    /**
     * Find zero or one Ps_eventbus_incremental_sync that matches the filter.
     * @param {ps_eventbus_incremental_syncFindUniqueArgs} args - Arguments to find a Ps_eventbus_incremental_sync
     * @example
     * // Get one Ps_eventbus_incremental_sync
     * const ps_eventbus_incremental_sync = await prisma.ps_eventbus_incremental_sync.findUnique({
     *   where: {
     *     // ... provide filter here
     *   }
     * })
     */
    findUnique<T extends ps_eventbus_incremental_syncFindUniqueArgs>(args: SelectSubset<T, ps_eventbus_incremental_syncFindUniqueArgs<ExtArgs>>): Prisma__ps_eventbus_incremental_syncClient<$Result.GetResult<Prisma.$ps_eventbus_incremental_syncPayload<ExtArgs>, T, "findUnique", GlobalOmitOptions> | null, null, ExtArgs, GlobalOmitOptions>

    /**
     * Find one Ps_eventbus_incremental_sync that matches the filter or throw an error with `error.code='P2025'`
     * if no matches were found.
     * @param {ps_eventbus_incremental_syncFindUniqueOrThrowArgs} args - Arguments to find a Ps_eventbus_incremental_sync
     * @example
     * // Get one Ps_eventbus_incremental_sync
     * const ps_eventbus_incremental_sync = await prisma.ps_eventbus_incremental_sync.findUniqueOrThrow({
     *   where: {
     *     // ... provide filter here
     *   }
     * })
     */
    findUniqueOrThrow<T extends ps_eventbus_incremental_syncFindUniqueOrThrowArgs>(args: SelectSubset<T, ps_eventbus_incremental_syncFindUniqueOrThrowArgs<ExtArgs>>): Prisma__ps_eventbus_incremental_syncClient<$Result.GetResult<Prisma.$ps_eventbus_incremental_syncPayload<ExtArgs>, T, "findUniqueOrThrow", GlobalOmitOptions>, never, ExtArgs, GlobalOmitOptions>

    /**
     * Find the first Ps_eventbus_incremental_sync that matches the filter.
     * Note, that providing `undefined` is treated as the value not being there.
     * Read more here: https://pris.ly/d/null-undefined
     * @param {ps_eventbus_incremental_syncFindFirstArgs} args - Arguments to find a Ps_eventbus_incremental_sync
     * @example
     * // Get one Ps_eventbus_incremental_sync
     * const ps_eventbus_incremental_sync = await prisma.ps_eventbus_incremental_sync.findFirst({
     *   where: {
     *     // ... provide filter here
     *   }
     * })
     */
    findFirst<T extends ps_eventbus_incremental_syncFindFirstArgs>(args?: SelectSubset<T, ps_eventbus_incremental_syncFindFirstArgs<ExtArgs>>): Prisma__ps_eventbus_incremental_syncClient<$Result.GetResult<Prisma.$ps_eventbus_incremental_syncPayload<ExtArgs>, T, "findFirst", GlobalOmitOptions> | null, null, ExtArgs, GlobalOmitOptions>

    /**
     * Find the first Ps_eventbus_incremental_sync that matches the filter or
     * throw `PrismaKnownClientError` with `P2025` code if no matches were found.
     * Note, that providing `undefined` is treated as the value not being there.
     * Read more here: https://pris.ly/d/null-undefined
     * @param {ps_eventbus_incremental_syncFindFirstOrThrowArgs} args - Arguments to find a Ps_eventbus_incremental_sync
     * @example
     * // Get one Ps_eventbus_incremental_sync
     * const ps_eventbus_incremental_sync = await prisma.ps_eventbus_incremental_sync.findFirstOrThrow({
     *   where: {
     *     // ... provide filter here
     *   }
     * })
     */
    findFirstOrThrow<T extends ps_eventbus_incremental_syncFindFirstOrThrowArgs>(args?: SelectSubset<T, ps_eventbus_incremental_syncFindFirstOrThrowArgs<ExtArgs>>): Prisma__ps_eventbus_incremental_syncClient<$Result.GetResult<Prisma.$ps_eventbus_incremental_syncPayload<ExtArgs>, T, "findFirstOrThrow", GlobalOmitOptions>, never, ExtArgs, GlobalOmitOptions>

    /**
     * Find zero or more Ps_eventbus_incremental_syncs that matches the filter.
     * Note, that providing `undefined` is treated as the value not being there.
     * Read more here: https://pris.ly/d/null-undefined
     * @param {ps_eventbus_incremental_syncFindManyArgs} args - Arguments to filter and select certain fields only.
     * @example
     * // Get all Ps_eventbus_incremental_syncs
     * const ps_eventbus_incremental_syncs = await prisma.ps_eventbus_incremental_sync.findMany()
     * 
     * // Get first 10 Ps_eventbus_incremental_syncs
     * const ps_eventbus_incremental_syncs = await prisma.ps_eventbus_incremental_sync.findMany({ take: 10 })
     * 
     * // Only select the `type`
     * const ps_eventbus_incremental_syncWithTypeOnly = await prisma.ps_eventbus_incremental_sync.findMany({ select: { type: true } })
     * 
     */
    findMany<T extends ps_eventbus_incremental_syncFindManyArgs>(args?: SelectSubset<T, ps_eventbus_incremental_syncFindManyArgs<ExtArgs>>): Prisma.PrismaPromise<$Result.GetResult<Prisma.$ps_eventbus_incremental_syncPayload<ExtArgs>, T, "findMany", GlobalOmitOptions>>

    /**
     * Create a Ps_eventbus_incremental_sync.
     * @param {ps_eventbus_incremental_syncCreateArgs} args - Arguments to create a Ps_eventbus_incremental_sync.
     * @example
     * // Create one Ps_eventbus_incremental_sync
     * const Ps_eventbus_incremental_sync = await prisma.ps_eventbus_incremental_sync.create({
     *   data: {
     *     // ... data to create a Ps_eventbus_incremental_sync
     *   }
     * })
     * 
     */
    create<T extends ps_eventbus_incremental_syncCreateArgs>(args: SelectSubset<T, ps_eventbus_incremental_syncCreateArgs<ExtArgs>>): Prisma__ps_eventbus_incremental_syncClient<$Result.GetResult<Prisma.$ps_eventbus_incremental_syncPayload<ExtArgs>, T, "create", GlobalOmitOptions>, never, ExtArgs, GlobalOmitOptions>

    /**
     * Create many Ps_eventbus_incremental_syncs.
     * @param {ps_eventbus_incremental_syncCreateManyArgs} args - Arguments to create many Ps_eventbus_incremental_syncs.
     * @example
     * // Create many Ps_eventbus_incremental_syncs
     * const ps_eventbus_incremental_sync = await prisma.ps_eventbus_incremental_sync.createMany({
     *   data: [
     *     // ... provide data here
     *   ]
     * })
     *     
     */
    createMany<T extends ps_eventbus_incremental_syncCreateManyArgs>(args?: SelectSubset<T, ps_eventbus_incremental_syncCreateManyArgs<ExtArgs>>): Prisma.PrismaPromise<BatchPayload>

    /**
     * Delete a Ps_eventbus_incremental_sync.
     * @param {ps_eventbus_incremental_syncDeleteArgs} args - Arguments to delete one Ps_eventbus_incremental_sync.
     * @example
     * // Delete one Ps_eventbus_incremental_sync
     * const Ps_eventbus_incremental_sync = await prisma.ps_eventbus_incremental_sync.delete({
     *   where: {
     *     // ... filter to delete one Ps_eventbus_incremental_sync
     *   }
     * })
     * 
     */
    delete<T extends ps_eventbus_incremental_syncDeleteArgs>(args: SelectSubset<T, ps_eventbus_incremental_syncDeleteArgs<ExtArgs>>): Prisma__ps_eventbus_incremental_syncClient<$Result.GetResult<Prisma.$ps_eventbus_incremental_syncPayload<ExtArgs>, T, "delete", GlobalOmitOptions>, never, ExtArgs, GlobalOmitOptions>

    /**
     * Update one Ps_eventbus_incremental_sync.
     * @param {ps_eventbus_incremental_syncUpdateArgs} args - Arguments to update one Ps_eventbus_incremental_sync.
     * @example
     * // Update one Ps_eventbus_incremental_sync
     * const ps_eventbus_incremental_sync = await prisma.ps_eventbus_incremental_sync.update({
     *   where: {
     *     // ... provide filter here
     *   },
     *   data: {
     *     // ... provide data here
     *   }
     * })
     * 
     */
    update<T extends ps_eventbus_incremental_syncUpdateArgs>(args: SelectSubset<T, ps_eventbus_incremental_syncUpdateArgs<ExtArgs>>): Prisma__ps_eventbus_incremental_syncClient<$Result.GetResult<Prisma.$ps_eventbus_incremental_syncPayload<ExtArgs>, T, "update", GlobalOmitOptions>, never, ExtArgs, GlobalOmitOptions>

    /**
     * Delete zero or more Ps_eventbus_incremental_syncs.
     * @param {ps_eventbus_incremental_syncDeleteManyArgs} args - Arguments to filter Ps_eventbus_incremental_syncs to delete.
     * @example
     * // Delete a few Ps_eventbus_incremental_syncs
     * const { count } = await prisma.ps_eventbus_incremental_sync.deleteMany({
     *   where: {
     *     // ... provide filter here
     *   }
     * })
     * 
     */
    deleteMany<T extends ps_eventbus_incremental_syncDeleteManyArgs>(args?: SelectSubset<T, ps_eventbus_incremental_syncDeleteManyArgs<ExtArgs>>): Prisma.PrismaPromise<BatchPayload>

    /**
     * Update zero or more Ps_eventbus_incremental_syncs.
     * Note, that providing `undefined` is treated as the value not being there.
     * Read more here: https://pris.ly/d/null-undefined
     * @param {ps_eventbus_incremental_syncUpdateManyArgs} args - Arguments to update one or more rows.
     * @example
     * // Update many Ps_eventbus_incremental_syncs
     * const ps_eventbus_incremental_sync = await prisma.ps_eventbus_incremental_sync.updateMany({
     *   where: {
     *     // ... provide filter here
     *   },
     *   data: {
     *     // ... provide data here
     *   }
     * })
     * 
     */
    updateMany<T extends ps_eventbus_incremental_syncUpdateManyArgs>(args: SelectSubset<T, ps_eventbus_incremental_syncUpdateManyArgs<ExtArgs>>): Prisma.PrismaPromise<BatchPayload>

    /**
     * Create or update one Ps_eventbus_incremental_sync.
     * @param {ps_eventbus_incremental_syncUpsertArgs} args - Arguments to update or create a Ps_eventbus_incremental_sync.
     * @example
     * // Update or create a Ps_eventbus_incremental_sync
     * const ps_eventbus_incremental_sync = await prisma.ps_eventbus_incremental_sync.upsert({
     *   create: {
     *     // ... data to create a Ps_eventbus_incremental_sync
     *   },
     *   update: {
     *     // ... in case it already exists, update
     *   },
     *   where: {
     *     // ... the filter for the Ps_eventbus_incremental_sync we want to update
     *   }
     * })
     */
    upsert<T extends ps_eventbus_incremental_syncUpsertArgs>(args: SelectSubset<T, ps_eventbus_incremental_syncUpsertArgs<ExtArgs>>): Prisma__ps_eventbus_incremental_syncClient<$Result.GetResult<Prisma.$ps_eventbus_incremental_syncPayload<ExtArgs>, T, "upsert", GlobalOmitOptions>, never, ExtArgs, GlobalOmitOptions>


    /**
     * Count the number of Ps_eventbus_incremental_syncs.
     * Note, that providing `undefined` is treated as the value not being there.
     * Read more here: https://pris.ly/d/null-undefined
     * @param {ps_eventbus_incremental_syncCountArgs} args - Arguments to filter Ps_eventbus_incremental_syncs to count.
     * @example
     * // Count the number of Ps_eventbus_incremental_syncs
     * const count = await prisma.ps_eventbus_incremental_sync.count({
     *   where: {
     *     // ... the filter for the Ps_eventbus_incremental_syncs we want to count
     *   }
     * })
    **/
    count<T extends ps_eventbus_incremental_syncCountArgs>(
      args?: Subset<T, ps_eventbus_incremental_syncCountArgs>,
    ): Prisma.PrismaPromise<
      T extends $Utils.Record<'select', any>
        ? T['select'] extends true
          ? number
          : GetScalarType<T['select'], Ps_eventbus_incremental_syncCountAggregateOutputType>
        : number
    >

    /**
     * Allows you to perform aggregations operations on a Ps_eventbus_incremental_sync.
     * Note, that providing `undefined` is treated as the value not being there.
     * Read more here: https://pris.ly/d/null-undefined
     * @param {Ps_eventbus_incremental_syncAggregateArgs} args - Select which aggregations you would like to apply and on what fields.
     * @example
     * // Ordered by age ascending
     * // Where email contains prisma.io
     * // Limited to the 10 users
     * const aggregations = await prisma.user.aggregate({
     *   _avg: {
     *     age: true,
     *   },
     *   where: {
     *     email: {
     *       contains: "prisma.io",
     *     },
     *   },
     *   orderBy: {
     *     age: "asc",
     *   },
     *   take: 10,
     * })
    **/
    aggregate<T extends Ps_eventbus_incremental_syncAggregateArgs>(args: Subset<T, Ps_eventbus_incremental_syncAggregateArgs>): Prisma.PrismaPromise<GetPs_eventbus_incremental_syncAggregateType<T>>

    /**
     * Group by Ps_eventbus_incremental_sync.
     * Note, that providing `undefined` is treated as the value not being there.
     * Read more here: https://pris.ly/d/null-undefined
     * @param {ps_eventbus_incremental_syncGroupByArgs} args - Group by arguments.
     * @example
     * // Group by city, order by createdAt, get count
     * const result = await prisma.user.groupBy({
     *   by: ['city', 'createdAt'],
     *   orderBy: {
     *     createdAt: true
     *   },
     *   _count: {
     *     _all: true
     *   },
     * })
     * 
    **/
    groupBy<
      T extends ps_eventbus_incremental_syncGroupByArgs,
      HasSelectOrTake extends Or<
        Extends<'skip', Keys<T>>,
        Extends<'take', Keys<T>>
      >,
      OrderByArg extends True extends HasSelectOrTake
        ? { orderBy: ps_eventbus_incremental_syncGroupByArgs['orderBy'] }
        : { orderBy?: ps_eventbus_incremental_syncGroupByArgs['orderBy'] },
      OrderFields extends ExcludeUnderscoreKeys<Keys<MaybeTupleToUnion<T['orderBy']>>>,
      ByFields extends MaybeTupleToUnion<T['by']>,
      ByValid extends Has<ByFields, OrderFields>,
      HavingFields extends GetHavingFields<T['having']>,
      HavingValid extends Has<ByFields, HavingFields>,
      ByEmpty extends T['by'] extends never[] ? True : False,
      InputErrors extends ByEmpty extends True
      ? `Error: "by" must not be empty.`
      : HavingValid extends False
      ? {
          [P in HavingFields]: P extends ByFields
            ? never
            : P extends string
            ? `Error: Field "${P}" used in "having" needs to be provided in "by".`
            : [
                Error,
                'Field ',
                P,
                ` in "having" needs to be provided in "by"`,
              ]
        }[HavingFields]
      : 'take' extends Keys<T>
      ? 'orderBy' extends Keys<T>
        ? ByValid extends True
          ? {}
          : {
              [P in OrderFields]: P extends ByFields
                ? never
                : `Error: Field "${P}" in "orderBy" needs to be provided in "by"`
            }[OrderFields]
        : 'Error: If you provide "take", you also need to provide "orderBy"'
      : 'skip' extends Keys<T>
      ? 'orderBy' extends Keys<T>
        ? ByValid extends True
          ? {}
          : {
              [P in OrderFields]: P extends ByFields
                ? never
                : `Error: Field "${P}" in "orderBy" needs to be provided in "by"`
            }[OrderFields]
        : 'Error: If you provide "skip", you also need to provide "orderBy"'
      : ByValid extends True
      ? {}
      : {
          [P in OrderFields]: P extends ByFields
            ? never
            : `Error: Field "${P}" in "orderBy" needs to be provided in "by"`
        }[OrderFields]
    >(args: SubsetIntersection<T, ps_eventbus_incremental_syncGroupByArgs, OrderByArg> & InputErrors): {} extends InputErrors ? GetPs_eventbus_incremental_syncGroupByPayload<T> : Prisma.PrismaPromise<InputErrors>
  /**
   * Fields of the ps_eventbus_incremental_sync model
   */
  readonly fields: ps_eventbus_incremental_syncFieldRefs;
  }

  /**
   * The delegate class that acts as a "Promise-like" for ps_eventbus_incremental_sync.
   * Why is this prefixed with `Prisma__`?
   * Because we want to prevent naming conflicts as mentioned in
   * https://github.com/prisma/prisma-client-js/issues/707
   */
  export interface Prisma__ps_eventbus_incremental_syncClient<T, Null = never, ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs, GlobalOmitOptions = {}> extends Prisma.PrismaPromise<T> {
    readonly [Symbol.toStringTag]: "PrismaPromise"
    /**
     * Attaches callbacks for the resolution and/or rejection of the Promise.
     * @param onfulfilled The callback to execute when the Promise is resolved.
     * @param onrejected The callback to execute when the Promise is rejected.
     * @returns A Promise for the completion of which ever callback is executed.
     */
    then<TResult1 = T, TResult2 = never>(onfulfilled?: ((value: T) => TResult1 | PromiseLike<TResult1>) | undefined | null, onrejected?: ((reason: any) => TResult2 | PromiseLike<TResult2>) | undefined | null): $Utils.JsPromise<TResult1 | TResult2>
    /**
     * Attaches a callback for only the rejection of the Promise.
     * @param onrejected The callback to execute when the Promise is rejected.
     * @returns A Promise for the completion of the callback.
     */
    catch<TResult = never>(onrejected?: ((reason: any) => TResult | PromiseLike<TResult>) | undefined | null): $Utils.JsPromise<T | TResult>
    /**
     * Attaches a callback that is invoked when the Promise is settled (fulfilled or rejected). The
     * resolved value cannot be modified from the callback.
     * @param onfinally The callback to execute when the Promise is settled (fulfilled or rejected).
     * @returns A Promise for the completion of the callback.
     */
    finally(onfinally?: (() => void) | undefined | null): $Utils.JsPromise<T>
  }




  /**
   * Fields of the ps_eventbus_incremental_sync model
   */
  interface ps_eventbus_incremental_syncFieldRefs {
    readonly type: FieldRef<"ps_eventbus_incremental_sync", 'String'>
    readonly action: FieldRef<"ps_eventbus_incremental_sync", 'String'>
    readonly id_object: FieldRef<"ps_eventbus_incremental_sync", 'String'>
    readonly id_shop: FieldRef<"ps_eventbus_incremental_sync", 'Int'>
    readonly lang_iso: FieldRef<"ps_eventbus_incremental_sync", 'String'>
    readonly created_at: FieldRef<"ps_eventbus_incremental_sync", 'DateTime'>
  }
    

  // Custom InputTypes
  /**
   * ps_eventbus_incremental_sync findUnique
   */
  export type ps_eventbus_incremental_syncFindUniqueArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_eventbus_incremental_sync
     */
    select?: ps_eventbus_incremental_syncSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_eventbus_incremental_sync
     */
    omit?: ps_eventbus_incremental_syncOmit<ExtArgs> | null
    /**
     * Filter, which ps_eventbus_incremental_sync to fetch.
     */
    where: ps_eventbus_incremental_syncWhereUniqueInput
  }

  /**
   * ps_eventbus_incremental_sync findUniqueOrThrow
   */
  export type ps_eventbus_incremental_syncFindUniqueOrThrowArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_eventbus_incremental_sync
     */
    select?: ps_eventbus_incremental_syncSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_eventbus_incremental_sync
     */
    omit?: ps_eventbus_incremental_syncOmit<ExtArgs> | null
    /**
     * Filter, which ps_eventbus_incremental_sync to fetch.
     */
    where: ps_eventbus_incremental_syncWhereUniqueInput
  }

  /**
   * ps_eventbus_incremental_sync findFirst
   */
  export type ps_eventbus_incremental_syncFindFirstArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_eventbus_incremental_sync
     */
    select?: ps_eventbus_incremental_syncSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_eventbus_incremental_sync
     */
    omit?: ps_eventbus_incremental_syncOmit<ExtArgs> | null
    /**
     * Filter, which ps_eventbus_incremental_sync to fetch.
     */
    where?: ps_eventbus_incremental_syncWhereInput
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/sorting Sorting Docs}
     * 
     * Determine the order of ps_eventbus_incremental_syncs to fetch.
     */
    orderBy?: ps_eventbus_incremental_syncOrderByWithRelationInput | ps_eventbus_incremental_syncOrderByWithRelationInput[]
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination#cursor-based-pagination Cursor Docs}
     * 
     * Sets the position for searching for ps_eventbus_incremental_syncs.
     */
    cursor?: ps_eventbus_incremental_syncWhereUniqueInput
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination Pagination Docs}
     * 
     * Take `±n` ps_eventbus_incremental_syncs from the position of the cursor.
     */
    take?: number
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination Pagination Docs}
     * 
     * Skip the first `n` ps_eventbus_incremental_syncs.
     */
    skip?: number
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/distinct Distinct Docs}
     * 
     * Filter by unique combinations of ps_eventbus_incremental_syncs.
     */
    distinct?: Ps_eventbus_incremental_syncScalarFieldEnum | Ps_eventbus_incremental_syncScalarFieldEnum[]
  }

  /**
   * ps_eventbus_incremental_sync findFirstOrThrow
   */
  export type ps_eventbus_incremental_syncFindFirstOrThrowArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_eventbus_incremental_sync
     */
    select?: ps_eventbus_incremental_syncSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_eventbus_incremental_sync
     */
    omit?: ps_eventbus_incremental_syncOmit<ExtArgs> | null
    /**
     * Filter, which ps_eventbus_incremental_sync to fetch.
     */
    where?: ps_eventbus_incremental_syncWhereInput
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/sorting Sorting Docs}
     * 
     * Determine the order of ps_eventbus_incremental_syncs to fetch.
     */
    orderBy?: ps_eventbus_incremental_syncOrderByWithRelationInput | ps_eventbus_incremental_syncOrderByWithRelationInput[]
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination#cursor-based-pagination Cursor Docs}
     * 
     * Sets the position for searching for ps_eventbus_incremental_syncs.
     */
    cursor?: ps_eventbus_incremental_syncWhereUniqueInput
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination Pagination Docs}
     * 
     * Take `±n` ps_eventbus_incremental_syncs from the position of the cursor.
     */
    take?: number
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination Pagination Docs}
     * 
     * Skip the first `n` ps_eventbus_incremental_syncs.
     */
    skip?: number
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/distinct Distinct Docs}
     * 
     * Filter by unique combinations of ps_eventbus_incremental_syncs.
     */
    distinct?: Ps_eventbus_incremental_syncScalarFieldEnum | Ps_eventbus_incremental_syncScalarFieldEnum[]
  }

  /**
   * ps_eventbus_incremental_sync findMany
   */
  export type ps_eventbus_incremental_syncFindManyArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_eventbus_incremental_sync
     */
    select?: ps_eventbus_incremental_syncSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_eventbus_incremental_sync
     */
    omit?: ps_eventbus_incremental_syncOmit<ExtArgs> | null
    /**
     * Filter, which ps_eventbus_incremental_syncs to fetch.
     */
    where?: ps_eventbus_incremental_syncWhereInput
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/sorting Sorting Docs}
     * 
     * Determine the order of ps_eventbus_incremental_syncs to fetch.
     */
    orderBy?: ps_eventbus_incremental_syncOrderByWithRelationInput | ps_eventbus_incremental_syncOrderByWithRelationInput[]
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination#cursor-based-pagination Cursor Docs}
     * 
     * Sets the position for listing ps_eventbus_incremental_syncs.
     */
    cursor?: ps_eventbus_incremental_syncWhereUniqueInput
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination Pagination Docs}
     * 
     * Take `±n` ps_eventbus_incremental_syncs from the position of the cursor.
     */
    take?: number
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination Pagination Docs}
     * 
     * Skip the first `n` ps_eventbus_incremental_syncs.
     */
    skip?: number
    distinct?: Ps_eventbus_incremental_syncScalarFieldEnum | Ps_eventbus_incremental_syncScalarFieldEnum[]
  }

  /**
   * ps_eventbus_incremental_sync create
   */
  export type ps_eventbus_incremental_syncCreateArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_eventbus_incremental_sync
     */
    select?: ps_eventbus_incremental_syncSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_eventbus_incremental_sync
     */
    omit?: ps_eventbus_incremental_syncOmit<ExtArgs> | null
    /**
     * The data needed to create a ps_eventbus_incremental_sync.
     */
    data: XOR<ps_eventbus_incremental_syncCreateInput, ps_eventbus_incremental_syncUncheckedCreateInput>
  }

  /**
   * ps_eventbus_incremental_sync createMany
   */
  export type ps_eventbus_incremental_syncCreateManyArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * The data used to create many ps_eventbus_incremental_syncs.
     */
    data: ps_eventbus_incremental_syncCreateManyInput | ps_eventbus_incremental_syncCreateManyInput[]
    skipDuplicates?: boolean
  }

  /**
   * ps_eventbus_incremental_sync update
   */
  export type ps_eventbus_incremental_syncUpdateArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_eventbus_incremental_sync
     */
    select?: ps_eventbus_incremental_syncSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_eventbus_incremental_sync
     */
    omit?: ps_eventbus_incremental_syncOmit<ExtArgs> | null
    /**
     * The data needed to update a ps_eventbus_incremental_sync.
     */
    data: XOR<ps_eventbus_incremental_syncUpdateInput, ps_eventbus_incremental_syncUncheckedUpdateInput>
    /**
     * Choose, which ps_eventbus_incremental_sync to update.
     */
    where: ps_eventbus_incremental_syncWhereUniqueInput
  }

  /**
   * ps_eventbus_incremental_sync updateMany
   */
  export type ps_eventbus_incremental_syncUpdateManyArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * The data used to update ps_eventbus_incremental_syncs.
     */
    data: XOR<ps_eventbus_incremental_syncUpdateManyMutationInput, ps_eventbus_incremental_syncUncheckedUpdateManyInput>
    /**
     * Filter which ps_eventbus_incremental_syncs to update
     */
    where?: ps_eventbus_incremental_syncWhereInput
    /**
     * Limit how many ps_eventbus_incremental_syncs to update.
     */
    limit?: number
  }

  /**
   * ps_eventbus_incremental_sync upsert
   */
  export type ps_eventbus_incremental_syncUpsertArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_eventbus_incremental_sync
     */
    select?: ps_eventbus_incremental_syncSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_eventbus_incremental_sync
     */
    omit?: ps_eventbus_incremental_syncOmit<ExtArgs> | null
    /**
     * The filter to search for the ps_eventbus_incremental_sync to update in case it exists.
     */
    where: ps_eventbus_incremental_syncWhereUniqueInput
    /**
     * In case the ps_eventbus_incremental_sync found by the `where` argument doesn't exist, create a new ps_eventbus_incremental_sync with this data.
     */
    create: XOR<ps_eventbus_incremental_syncCreateInput, ps_eventbus_incremental_syncUncheckedCreateInput>
    /**
     * In case the ps_eventbus_incremental_sync was found with the provided `where` argument, update it with this data.
     */
    update: XOR<ps_eventbus_incremental_syncUpdateInput, ps_eventbus_incremental_syncUncheckedUpdateInput>
  }

  /**
   * ps_eventbus_incremental_sync delete
   */
  export type ps_eventbus_incremental_syncDeleteArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_eventbus_incremental_sync
     */
    select?: ps_eventbus_incremental_syncSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_eventbus_incremental_sync
     */
    omit?: ps_eventbus_incremental_syncOmit<ExtArgs> | null
    /**
     * Filter which ps_eventbus_incremental_sync to delete.
     */
    where: ps_eventbus_incremental_syncWhereUniqueInput
  }

  /**
   * ps_eventbus_incremental_sync deleteMany
   */
  export type ps_eventbus_incremental_syncDeleteManyArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Filter which ps_eventbus_incremental_syncs to delete
     */
    where?: ps_eventbus_incremental_syncWhereInput
    /**
     * Limit how many ps_eventbus_incremental_syncs to delete.
     */
    limit?: number
  }

  /**
   * ps_eventbus_incremental_sync without action
   */
  export type ps_eventbus_incremental_syncDefaultArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_eventbus_incremental_sync
     */
    select?: ps_eventbus_incremental_syncSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_eventbus_incremental_sync
     */
    omit?: ps_eventbus_incremental_syncOmit<ExtArgs> | null
  }


  /**
   * Model ps_eventbus_job
   */

  export type AggregatePs_eventbus_job = {
    _count: Ps_eventbus_jobCountAggregateOutputType | null
    _min: Ps_eventbus_jobMinAggregateOutputType | null
    _max: Ps_eventbus_jobMaxAggregateOutputType | null
  }

  export type Ps_eventbus_jobMinAggregateOutputType = {
    job_id: string | null
    created_at: Date | null
  }

  export type Ps_eventbus_jobMaxAggregateOutputType = {
    job_id: string | null
    created_at: Date | null
  }

  export type Ps_eventbus_jobCountAggregateOutputType = {
    job_id: number
    created_at: number
    _all: number
  }


  export type Ps_eventbus_jobMinAggregateInputType = {
    job_id?: true
    created_at?: true
  }

  export type Ps_eventbus_jobMaxAggregateInputType = {
    job_id?: true
    created_at?: true
  }

  export type Ps_eventbus_jobCountAggregateInputType = {
    job_id?: true
    created_at?: true
    _all?: true
  }

  export type Ps_eventbus_jobAggregateArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Filter which ps_eventbus_job to aggregate.
     */
    where?: ps_eventbus_jobWhereInput
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/sorting Sorting Docs}
     * 
     * Determine the order of ps_eventbus_jobs to fetch.
     */
    orderBy?: ps_eventbus_jobOrderByWithRelationInput | ps_eventbus_jobOrderByWithRelationInput[]
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination#cursor-based-pagination Cursor Docs}
     * 
     * Sets the start position
     */
    cursor?: ps_eventbus_jobWhereUniqueInput
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination Pagination Docs}
     * 
     * Take `±n` ps_eventbus_jobs from the position of the cursor.
     */
    take?: number
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination Pagination Docs}
     * 
     * Skip the first `n` ps_eventbus_jobs.
     */
    skip?: number
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/aggregations Aggregation Docs}
     * 
     * Count returned ps_eventbus_jobs
    **/
    _count?: true | Ps_eventbus_jobCountAggregateInputType
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/aggregations Aggregation Docs}
     * 
     * Select which fields to find the minimum value
    **/
    _min?: Ps_eventbus_jobMinAggregateInputType
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/aggregations Aggregation Docs}
     * 
     * Select which fields to find the maximum value
    **/
    _max?: Ps_eventbus_jobMaxAggregateInputType
  }

  export type GetPs_eventbus_jobAggregateType<T extends Ps_eventbus_jobAggregateArgs> = {
        [P in keyof T & keyof AggregatePs_eventbus_job]: P extends '_count' | 'count'
      ? T[P] extends true
        ? number
        : GetScalarType<T[P], AggregatePs_eventbus_job[P]>
      : GetScalarType<T[P], AggregatePs_eventbus_job[P]>
  }




  export type ps_eventbus_jobGroupByArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    where?: ps_eventbus_jobWhereInput
    orderBy?: ps_eventbus_jobOrderByWithAggregationInput | ps_eventbus_jobOrderByWithAggregationInput[]
    by: Ps_eventbus_jobScalarFieldEnum[] | Ps_eventbus_jobScalarFieldEnum
    having?: ps_eventbus_jobScalarWhereWithAggregatesInput
    take?: number
    skip?: number
    _count?: Ps_eventbus_jobCountAggregateInputType | true
    _min?: Ps_eventbus_jobMinAggregateInputType
    _max?: Ps_eventbus_jobMaxAggregateInputType
  }

  export type Ps_eventbus_jobGroupByOutputType = {
    job_id: string
    created_at: Date
    _count: Ps_eventbus_jobCountAggregateOutputType | null
    _min: Ps_eventbus_jobMinAggregateOutputType | null
    _max: Ps_eventbus_jobMaxAggregateOutputType | null
  }

  type GetPs_eventbus_jobGroupByPayload<T extends ps_eventbus_jobGroupByArgs> = Prisma.PrismaPromise<
    Array<
      PickEnumerable<Ps_eventbus_jobGroupByOutputType, T['by']> &
        {
          [P in ((keyof T) & (keyof Ps_eventbus_jobGroupByOutputType))]: P extends '_count'
            ? T[P] extends boolean
              ? number
              : GetScalarType<T[P], Ps_eventbus_jobGroupByOutputType[P]>
            : GetScalarType<T[P], Ps_eventbus_jobGroupByOutputType[P]>
        }
      >
    >


  export type ps_eventbus_jobSelect<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = $Extensions.GetSelect<{
    job_id?: boolean
    created_at?: boolean
  }, ExtArgs["result"]["ps_eventbus_job"]>



  export type ps_eventbus_jobSelectScalar = {
    job_id?: boolean
    created_at?: boolean
  }

  export type ps_eventbus_jobOmit<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = $Extensions.GetOmit<"job_id" | "created_at", ExtArgs["result"]["ps_eventbus_job"]>

  export type $ps_eventbus_jobPayload<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    name: "ps_eventbus_job"
    objects: {}
    scalars: $Extensions.GetPayloadResult<{
      job_id: string
      created_at: Date
    }, ExtArgs["result"]["ps_eventbus_job"]>
    composites: {}
  }

  type ps_eventbus_jobGetPayload<S extends boolean | null | undefined | ps_eventbus_jobDefaultArgs> = $Result.GetResult<Prisma.$ps_eventbus_jobPayload, S>

  type ps_eventbus_jobCountArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> =
    Omit<ps_eventbus_jobFindManyArgs, 'select' | 'include' | 'distinct' | 'omit'> & {
      select?: Ps_eventbus_jobCountAggregateInputType | true
    }

  export interface ps_eventbus_jobDelegate<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs, GlobalOmitOptions = {}> {
    [K: symbol]: { types: Prisma.TypeMap<ExtArgs>['model']['ps_eventbus_job'], meta: { name: 'ps_eventbus_job' } }
    /**
     * Find zero or one Ps_eventbus_job that matches the filter.
     * @param {ps_eventbus_jobFindUniqueArgs} args - Arguments to find a Ps_eventbus_job
     * @example
     * // Get one Ps_eventbus_job
     * const ps_eventbus_job = await prisma.ps_eventbus_job.findUnique({
     *   where: {
     *     // ... provide filter here
     *   }
     * })
     */
    findUnique<T extends ps_eventbus_jobFindUniqueArgs>(args: SelectSubset<T, ps_eventbus_jobFindUniqueArgs<ExtArgs>>): Prisma__ps_eventbus_jobClient<$Result.GetResult<Prisma.$ps_eventbus_jobPayload<ExtArgs>, T, "findUnique", GlobalOmitOptions> | null, null, ExtArgs, GlobalOmitOptions>

    /**
     * Find one Ps_eventbus_job that matches the filter or throw an error with `error.code='P2025'`
     * if no matches were found.
     * @param {ps_eventbus_jobFindUniqueOrThrowArgs} args - Arguments to find a Ps_eventbus_job
     * @example
     * // Get one Ps_eventbus_job
     * const ps_eventbus_job = await prisma.ps_eventbus_job.findUniqueOrThrow({
     *   where: {
     *     // ... provide filter here
     *   }
     * })
     */
    findUniqueOrThrow<T extends ps_eventbus_jobFindUniqueOrThrowArgs>(args: SelectSubset<T, ps_eventbus_jobFindUniqueOrThrowArgs<ExtArgs>>): Prisma__ps_eventbus_jobClient<$Result.GetResult<Prisma.$ps_eventbus_jobPayload<ExtArgs>, T, "findUniqueOrThrow", GlobalOmitOptions>, never, ExtArgs, GlobalOmitOptions>

    /**
     * Find the first Ps_eventbus_job that matches the filter.
     * Note, that providing `undefined` is treated as the value not being there.
     * Read more here: https://pris.ly/d/null-undefined
     * @param {ps_eventbus_jobFindFirstArgs} args - Arguments to find a Ps_eventbus_job
     * @example
     * // Get one Ps_eventbus_job
     * const ps_eventbus_job = await prisma.ps_eventbus_job.findFirst({
     *   where: {
     *     // ... provide filter here
     *   }
     * })
     */
    findFirst<T extends ps_eventbus_jobFindFirstArgs>(args?: SelectSubset<T, ps_eventbus_jobFindFirstArgs<ExtArgs>>): Prisma__ps_eventbus_jobClient<$Result.GetResult<Prisma.$ps_eventbus_jobPayload<ExtArgs>, T, "findFirst", GlobalOmitOptions> | null, null, ExtArgs, GlobalOmitOptions>

    /**
     * Find the first Ps_eventbus_job that matches the filter or
     * throw `PrismaKnownClientError` with `P2025` code if no matches were found.
     * Note, that providing `undefined` is treated as the value not being there.
     * Read more here: https://pris.ly/d/null-undefined
     * @param {ps_eventbus_jobFindFirstOrThrowArgs} args - Arguments to find a Ps_eventbus_job
     * @example
     * // Get one Ps_eventbus_job
     * const ps_eventbus_job = await prisma.ps_eventbus_job.findFirstOrThrow({
     *   where: {
     *     // ... provide filter here
     *   }
     * })
     */
    findFirstOrThrow<T extends ps_eventbus_jobFindFirstOrThrowArgs>(args?: SelectSubset<T, ps_eventbus_jobFindFirstOrThrowArgs<ExtArgs>>): Prisma__ps_eventbus_jobClient<$Result.GetResult<Prisma.$ps_eventbus_jobPayload<ExtArgs>, T, "findFirstOrThrow", GlobalOmitOptions>, never, ExtArgs, GlobalOmitOptions>

    /**
     * Find zero or more Ps_eventbus_jobs that matches the filter.
     * Note, that providing `undefined` is treated as the value not being there.
     * Read more here: https://pris.ly/d/null-undefined
     * @param {ps_eventbus_jobFindManyArgs} args - Arguments to filter and select certain fields only.
     * @example
     * // Get all Ps_eventbus_jobs
     * const ps_eventbus_jobs = await prisma.ps_eventbus_job.findMany()
     * 
     * // Get first 10 Ps_eventbus_jobs
     * const ps_eventbus_jobs = await prisma.ps_eventbus_job.findMany({ take: 10 })
     * 
     * // Only select the `job_id`
     * const ps_eventbus_jobWithJob_idOnly = await prisma.ps_eventbus_job.findMany({ select: { job_id: true } })
     * 
     */
    findMany<T extends ps_eventbus_jobFindManyArgs>(args?: SelectSubset<T, ps_eventbus_jobFindManyArgs<ExtArgs>>): Prisma.PrismaPromise<$Result.GetResult<Prisma.$ps_eventbus_jobPayload<ExtArgs>, T, "findMany", GlobalOmitOptions>>

    /**
     * Create a Ps_eventbus_job.
     * @param {ps_eventbus_jobCreateArgs} args - Arguments to create a Ps_eventbus_job.
     * @example
     * // Create one Ps_eventbus_job
     * const Ps_eventbus_job = await prisma.ps_eventbus_job.create({
     *   data: {
     *     // ... data to create a Ps_eventbus_job
     *   }
     * })
     * 
     */
    create<T extends ps_eventbus_jobCreateArgs>(args: SelectSubset<T, ps_eventbus_jobCreateArgs<ExtArgs>>): Prisma__ps_eventbus_jobClient<$Result.GetResult<Prisma.$ps_eventbus_jobPayload<ExtArgs>, T, "create", GlobalOmitOptions>, never, ExtArgs, GlobalOmitOptions>

    /**
     * Create many Ps_eventbus_jobs.
     * @param {ps_eventbus_jobCreateManyArgs} args - Arguments to create many Ps_eventbus_jobs.
     * @example
     * // Create many Ps_eventbus_jobs
     * const ps_eventbus_job = await prisma.ps_eventbus_job.createMany({
     *   data: [
     *     // ... provide data here
     *   ]
     * })
     *     
     */
    createMany<T extends ps_eventbus_jobCreateManyArgs>(args?: SelectSubset<T, ps_eventbus_jobCreateManyArgs<ExtArgs>>): Prisma.PrismaPromise<BatchPayload>

    /**
     * Delete a Ps_eventbus_job.
     * @param {ps_eventbus_jobDeleteArgs} args - Arguments to delete one Ps_eventbus_job.
     * @example
     * // Delete one Ps_eventbus_job
     * const Ps_eventbus_job = await prisma.ps_eventbus_job.delete({
     *   where: {
     *     // ... filter to delete one Ps_eventbus_job
     *   }
     * })
     * 
     */
    delete<T extends ps_eventbus_jobDeleteArgs>(args: SelectSubset<T, ps_eventbus_jobDeleteArgs<ExtArgs>>): Prisma__ps_eventbus_jobClient<$Result.GetResult<Prisma.$ps_eventbus_jobPayload<ExtArgs>, T, "delete", GlobalOmitOptions>, never, ExtArgs, GlobalOmitOptions>

    /**
     * Update one Ps_eventbus_job.
     * @param {ps_eventbus_jobUpdateArgs} args - Arguments to update one Ps_eventbus_job.
     * @example
     * // Update one Ps_eventbus_job
     * const ps_eventbus_job = await prisma.ps_eventbus_job.update({
     *   where: {
     *     // ... provide filter here
     *   },
     *   data: {
     *     // ... provide data here
     *   }
     * })
     * 
     */
    update<T extends ps_eventbus_jobUpdateArgs>(args: SelectSubset<T, ps_eventbus_jobUpdateArgs<ExtArgs>>): Prisma__ps_eventbus_jobClient<$Result.GetResult<Prisma.$ps_eventbus_jobPayload<ExtArgs>, T, "update", GlobalOmitOptions>, never, ExtArgs, GlobalOmitOptions>

    /**
     * Delete zero or more Ps_eventbus_jobs.
     * @param {ps_eventbus_jobDeleteManyArgs} args - Arguments to filter Ps_eventbus_jobs to delete.
     * @example
     * // Delete a few Ps_eventbus_jobs
     * const { count } = await prisma.ps_eventbus_job.deleteMany({
     *   where: {
     *     // ... provide filter here
     *   }
     * })
     * 
     */
    deleteMany<T extends ps_eventbus_jobDeleteManyArgs>(args?: SelectSubset<T, ps_eventbus_jobDeleteManyArgs<ExtArgs>>): Prisma.PrismaPromise<BatchPayload>

    /**
     * Update zero or more Ps_eventbus_jobs.
     * Note, that providing `undefined` is treated as the value not being there.
     * Read more here: https://pris.ly/d/null-undefined
     * @param {ps_eventbus_jobUpdateManyArgs} args - Arguments to update one or more rows.
     * @example
     * // Update many Ps_eventbus_jobs
     * const ps_eventbus_job = await prisma.ps_eventbus_job.updateMany({
     *   where: {
     *     // ... provide filter here
     *   },
     *   data: {
     *     // ... provide data here
     *   }
     * })
     * 
     */
    updateMany<T extends ps_eventbus_jobUpdateManyArgs>(args: SelectSubset<T, ps_eventbus_jobUpdateManyArgs<ExtArgs>>): Prisma.PrismaPromise<BatchPayload>

    /**
     * Create or update one Ps_eventbus_job.
     * @param {ps_eventbus_jobUpsertArgs} args - Arguments to update or create a Ps_eventbus_job.
     * @example
     * // Update or create a Ps_eventbus_job
     * const ps_eventbus_job = await prisma.ps_eventbus_job.upsert({
     *   create: {
     *     // ... data to create a Ps_eventbus_job
     *   },
     *   update: {
     *     // ... in case it already exists, update
     *   },
     *   where: {
     *     // ... the filter for the Ps_eventbus_job we want to update
     *   }
     * })
     */
    upsert<T extends ps_eventbus_jobUpsertArgs>(args: SelectSubset<T, ps_eventbus_jobUpsertArgs<ExtArgs>>): Prisma__ps_eventbus_jobClient<$Result.GetResult<Prisma.$ps_eventbus_jobPayload<ExtArgs>, T, "upsert", GlobalOmitOptions>, never, ExtArgs, GlobalOmitOptions>


    /**
     * Count the number of Ps_eventbus_jobs.
     * Note, that providing `undefined` is treated as the value not being there.
     * Read more here: https://pris.ly/d/null-undefined
     * @param {ps_eventbus_jobCountArgs} args - Arguments to filter Ps_eventbus_jobs to count.
     * @example
     * // Count the number of Ps_eventbus_jobs
     * const count = await prisma.ps_eventbus_job.count({
     *   where: {
     *     // ... the filter for the Ps_eventbus_jobs we want to count
     *   }
     * })
    **/
    count<T extends ps_eventbus_jobCountArgs>(
      args?: Subset<T, ps_eventbus_jobCountArgs>,
    ): Prisma.PrismaPromise<
      T extends $Utils.Record<'select', any>
        ? T['select'] extends true
          ? number
          : GetScalarType<T['select'], Ps_eventbus_jobCountAggregateOutputType>
        : number
    >

    /**
     * Allows you to perform aggregations operations on a Ps_eventbus_job.
     * Note, that providing `undefined` is treated as the value not being there.
     * Read more here: https://pris.ly/d/null-undefined
     * @param {Ps_eventbus_jobAggregateArgs} args - Select which aggregations you would like to apply and on what fields.
     * @example
     * // Ordered by age ascending
     * // Where email contains prisma.io
     * // Limited to the 10 users
     * const aggregations = await prisma.user.aggregate({
     *   _avg: {
     *     age: true,
     *   },
     *   where: {
     *     email: {
     *       contains: "prisma.io",
     *     },
     *   },
     *   orderBy: {
     *     age: "asc",
     *   },
     *   take: 10,
     * })
    **/
    aggregate<T extends Ps_eventbus_jobAggregateArgs>(args: Subset<T, Ps_eventbus_jobAggregateArgs>): Prisma.PrismaPromise<GetPs_eventbus_jobAggregateType<T>>

    /**
     * Group by Ps_eventbus_job.
     * Note, that providing `undefined` is treated as the value not being there.
     * Read more here: https://pris.ly/d/null-undefined
     * @param {ps_eventbus_jobGroupByArgs} args - Group by arguments.
     * @example
     * // Group by city, order by createdAt, get count
     * const result = await prisma.user.groupBy({
     *   by: ['city', 'createdAt'],
     *   orderBy: {
     *     createdAt: true
     *   },
     *   _count: {
     *     _all: true
     *   },
     * })
     * 
    **/
    groupBy<
      T extends ps_eventbus_jobGroupByArgs,
      HasSelectOrTake extends Or<
        Extends<'skip', Keys<T>>,
        Extends<'take', Keys<T>>
      >,
      OrderByArg extends True extends HasSelectOrTake
        ? { orderBy: ps_eventbus_jobGroupByArgs['orderBy'] }
        : { orderBy?: ps_eventbus_jobGroupByArgs['orderBy'] },
      OrderFields extends ExcludeUnderscoreKeys<Keys<MaybeTupleToUnion<T['orderBy']>>>,
      ByFields extends MaybeTupleToUnion<T['by']>,
      ByValid extends Has<ByFields, OrderFields>,
      HavingFields extends GetHavingFields<T['having']>,
      HavingValid extends Has<ByFields, HavingFields>,
      ByEmpty extends T['by'] extends never[] ? True : False,
      InputErrors extends ByEmpty extends True
      ? `Error: "by" must not be empty.`
      : HavingValid extends False
      ? {
          [P in HavingFields]: P extends ByFields
            ? never
            : P extends string
            ? `Error: Field "${P}" used in "having" needs to be provided in "by".`
            : [
                Error,
                'Field ',
                P,
                ` in "having" needs to be provided in "by"`,
              ]
        }[HavingFields]
      : 'take' extends Keys<T>
      ? 'orderBy' extends Keys<T>
        ? ByValid extends True
          ? {}
          : {
              [P in OrderFields]: P extends ByFields
                ? never
                : `Error: Field "${P}" in "orderBy" needs to be provided in "by"`
            }[OrderFields]
        : 'Error: If you provide "take", you also need to provide "orderBy"'
      : 'skip' extends Keys<T>
      ? 'orderBy' extends Keys<T>
        ? ByValid extends True
          ? {}
          : {
              [P in OrderFields]: P extends ByFields
                ? never
                : `Error: Field "${P}" in "orderBy" needs to be provided in "by"`
            }[OrderFields]
        : 'Error: If you provide "skip", you also need to provide "orderBy"'
      : ByValid extends True
      ? {}
      : {
          [P in OrderFields]: P extends ByFields
            ? never
            : `Error: Field "${P}" in "orderBy" needs to be provided in "by"`
        }[OrderFields]
    >(args: SubsetIntersection<T, ps_eventbus_jobGroupByArgs, OrderByArg> & InputErrors): {} extends InputErrors ? GetPs_eventbus_jobGroupByPayload<T> : Prisma.PrismaPromise<InputErrors>
  /**
   * Fields of the ps_eventbus_job model
   */
  readonly fields: ps_eventbus_jobFieldRefs;
  }

  /**
   * The delegate class that acts as a "Promise-like" for ps_eventbus_job.
   * Why is this prefixed with `Prisma__`?
   * Because we want to prevent naming conflicts as mentioned in
   * https://github.com/prisma/prisma-client-js/issues/707
   */
  export interface Prisma__ps_eventbus_jobClient<T, Null = never, ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs, GlobalOmitOptions = {}> extends Prisma.PrismaPromise<T> {
    readonly [Symbol.toStringTag]: "PrismaPromise"
    /**
     * Attaches callbacks for the resolution and/or rejection of the Promise.
     * @param onfulfilled The callback to execute when the Promise is resolved.
     * @param onrejected The callback to execute when the Promise is rejected.
     * @returns A Promise for the completion of which ever callback is executed.
     */
    then<TResult1 = T, TResult2 = never>(onfulfilled?: ((value: T) => TResult1 | PromiseLike<TResult1>) | undefined | null, onrejected?: ((reason: any) => TResult2 | PromiseLike<TResult2>) | undefined | null): $Utils.JsPromise<TResult1 | TResult2>
    /**
     * Attaches a callback for only the rejection of the Promise.
     * @param onrejected The callback to execute when the Promise is rejected.
     * @returns A Promise for the completion of the callback.
     */
    catch<TResult = never>(onrejected?: ((reason: any) => TResult | PromiseLike<TResult>) | undefined | null): $Utils.JsPromise<T | TResult>
    /**
     * Attaches a callback that is invoked when the Promise is settled (fulfilled or rejected). The
     * resolved value cannot be modified from the callback.
     * @param onfinally The callback to execute when the Promise is settled (fulfilled or rejected).
     * @returns A Promise for the completion of the callback.
     */
    finally(onfinally?: (() => void) | undefined | null): $Utils.JsPromise<T>
  }




  /**
   * Fields of the ps_eventbus_job model
   */
  interface ps_eventbus_jobFieldRefs {
    readonly job_id: FieldRef<"ps_eventbus_job", 'String'>
    readonly created_at: FieldRef<"ps_eventbus_job", 'DateTime'>
  }
    

  // Custom InputTypes
  /**
   * ps_eventbus_job findUnique
   */
  export type ps_eventbus_jobFindUniqueArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_eventbus_job
     */
    select?: ps_eventbus_jobSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_eventbus_job
     */
    omit?: ps_eventbus_jobOmit<ExtArgs> | null
    /**
     * Filter, which ps_eventbus_job to fetch.
     */
    where: ps_eventbus_jobWhereUniqueInput
  }

  /**
   * ps_eventbus_job findUniqueOrThrow
   */
  export type ps_eventbus_jobFindUniqueOrThrowArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_eventbus_job
     */
    select?: ps_eventbus_jobSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_eventbus_job
     */
    omit?: ps_eventbus_jobOmit<ExtArgs> | null
    /**
     * Filter, which ps_eventbus_job to fetch.
     */
    where: ps_eventbus_jobWhereUniqueInput
  }

  /**
   * ps_eventbus_job findFirst
   */
  export type ps_eventbus_jobFindFirstArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_eventbus_job
     */
    select?: ps_eventbus_jobSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_eventbus_job
     */
    omit?: ps_eventbus_jobOmit<ExtArgs> | null
    /**
     * Filter, which ps_eventbus_job to fetch.
     */
    where?: ps_eventbus_jobWhereInput
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/sorting Sorting Docs}
     * 
     * Determine the order of ps_eventbus_jobs to fetch.
     */
    orderBy?: ps_eventbus_jobOrderByWithRelationInput | ps_eventbus_jobOrderByWithRelationInput[]
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination#cursor-based-pagination Cursor Docs}
     * 
     * Sets the position for searching for ps_eventbus_jobs.
     */
    cursor?: ps_eventbus_jobWhereUniqueInput
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination Pagination Docs}
     * 
     * Take `±n` ps_eventbus_jobs from the position of the cursor.
     */
    take?: number
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination Pagination Docs}
     * 
     * Skip the first `n` ps_eventbus_jobs.
     */
    skip?: number
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/distinct Distinct Docs}
     * 
     * Filter by unique combinations of ps_eventbus_jobs.
     */
    distinct?: Ps_eventbus_jobScalarFieldEnum | Ps_eventbus_jobScalarFieldEnum[]
  }

  /**
   * ps_eventbus_job findFirstOrThrow
   */
  export type ps_eventbus_jobFindFirstOrThrowArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_eventbus_job
     */
    select?: ps_eventbus_jobSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_eventbus_job
     */
    omit?: ps_eventbus_jobOmit<ExtArgs> | null
    /**
     * Filter, which ps_eventbus_job to fetch.
     */
    where?: ps_eventbus_jobWhereInput
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/sorting Sorting Docs}
     * 
     * Determine the order of ps_eventbus_jobs to fetch.
     */
    orderBy?: ps_eventbus_jobOrderByWithRelationInput | ps_eventbus_jobOrderByWithRelationInput[]
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination#cursor-based-pagination Cursor Docs}
     * 
     * Sets the position for searching for ps_eventbus_jobs.
     */
    cursor?: ps_eventbus_jobWhereUniqueInput
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination Pagination Docs}
     * 
     * Take `±n` ps_eventbus_jobs from the position of the cursor.
     */
    take?: number
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination Pagination Docs}
     * 
     * Skip the first `n` ps_eventbus_jobs.
     */
    skip?: number
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/distinct Distinct Docs}
     * 
     * Filter by unique combinations of ps_eventbus_jobs.
     */
    distinct?: Ps_eventbus_jobScalarFieldEnum | Ps_eventbus_jobScalarFieldEnum[]
  }

  /**
   * ps_eventbus_job findMany
   */
  export type ps_eventbus_jobFindManyArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_eventbus_job
     */
    select?: ps_eventbus_jobSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_eventbus_job
     */
    omit?: ps_eventbus_jobOmit<ExtArgs> | null
    /**
     * Filter, which ps_eventbus_jobs to fetch.
     */
    where?: ps_eventbus_jobWhereInput
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/sorting Sorting Docs}
     * 
     * Determine the order of ps_eventbus_jobs to fetch.
     */
    orderBy?: ps_eventbus_jobOrderByWithRelationInput | ps_eventbus_jobOrderByWithRelationInput[]
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination#cursor-based-pagination Cursor Docs}
     * 
     * Sets the position for listing ps_eventbus_jobs.
     */
    cursor?: ps_eventbus_jobWhereUniqueInput
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination Pagination Docs}
     * 
     * Take `±n` ps_eventbus_jobs from the position of the cursor.
     */
    take?: number
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination Pagination Docs}
     * 
     * Skip the first `n` ps_eventbus_jobs.
     */
    skip?: number
    distinct?: Ps_eventbus_jobScalarFieldEnum | Ps_eventbus_jobScalarFieldEnum[]
  }

  /**
   * ps_eventbus_job create
   */
  export type ps_eventbus_jobCreateArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_eventbus_job
     */
    select?: ps_eventbus_jobSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_eventbus_job
     */
    omit?: ps_eventbus_jobOmit<ExtArgs> | null
    /**
     * The data needed to create a ps_eventbus_job.
     */
    data: XOR<ps_eventbus_jobCreateInput, ps_eventbus_jobUncheckedCreateInput>
  }

  /**
   * ps_eventbus_job createMany
   */
  export type ps_eventbus_jobCreateManyArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * The data used to create many ps_eventbus_jobs.
     */
    data: ps_eventbus_jobCreateManyInput | ps_eventbus_jobCreateManyInput[]
    skipDuplicates?: boolean
  }

  /**
   * ps_eventbus_job update
   */
  export type ps_eventbus_jobUpdateArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_eventbus_job
     */
    select?: ps_eventbus_jobSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_eventbus_job
     */
    omit?: ps_eventbus_jobOmit<ExtArgs> | null
    /**
     * The data needed to update a ps_eventbus_job.
     */
    data: XOR<ps_eventbus_jobUpdateInput, ps_eventbus_jobUncheckedUpdateInput>
    /**
     * Choose, which ps_eventbus_job to update.
     */
    where: ps_eventbus_jobWhereUniqueInput
  }

  /**
   * ps_eventbus_job updateMany
   */
  export type ps_eventbus_jobUpdateManyArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * The data used to update ps_eventbus_jobs.
     */
    data: XOR<ps_eventbus_jobUpdateManyMutationInput, ps_eventbus_jobUncheckedUpdateManyInput>
    /**
     * Filter which ps_eventbus_jobs to update
     */
    where?: ps_eventbus_jobWhereInput
    /**
     * Limit how many ps_eventbus_jobs to update.
     */
    limit?: number
  }

  /**
   * ps_eventbus_job upsert
   */
  export type ps_eventbus_jobUpsertArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_eventbus_job
     */
    select?: ps_eventbus_jobSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_eventbus_job
     */
    omit?: ps_eventbus_jobOmit<ExtArgs> | null
    /**
     * The filter to search for the ps_eventbus_job to update in case it exists.
     */
    where: ps_eventbus_jobWhereUniqueInput
    /**
     * In case the ps_eventbus_job found by the `where` argument doesn't exist, create a new ps_eventbus_job with this data.
     */
    create: XOR<ps_eventbus_jobCreateInput, ps_eventbus_jobUncheckedCreateInput>
    /**
     * In case the ps_eventbus_job was found with the provided `where` argument, update it with this data.
     */
    update: XOR<ps_eventbus_jobUpdateInput, ps_eventbus_jobUncheckedUpdateInput>
  }

  /**
   * ps_eventbus_job delete
   */
  export type ps_eventbus_jobDeleteArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_eventbus_job
     */
    select?: ps_eventbus_jobSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_eventbus_job
     */
    omit?: ps_eventbus_jobOmit<ExtArgs> | null
    /**
     * Filter which ps_eventbus_job to delete.
     */
    where: ps_eventbus_jobWhereUniqueInput
  }

  /**
   * ps_eventbus_job deleteMany
   */
  export type ps_eventbus_jobDeleteManyArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Filter which ps_eventbus_jobs to delete
     */
    where?: ps_eventbus_jobWhereInput
    /**
     * Limit how many ps_eventbus_jobs to delete.
     */
    limit?: number
  }

  /**
   * ps_eventbus_job without action
   */
  export type ps_eventbus_jobDefaultArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_eventbus_job
     */
    select?: ps_eventbus_jobSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_eventbus_job
     */
    omit?: ps_eventbus_jobOmit<ExtArgs> | null
  }


  /**
   * Model ps_eventbus_live_sync
   */

  export type AggregatePs_eventbus_live_sync = {
    _count: Ps_eventbus_live_syncCountAggregateOutputType | null
    _min: Ps_eventbus_live_syncMinAggregateOutputType | null
    _max: Ps_eventbus_live_syncMaxAggregateOutputType | null
  }

  export type Ps_eventbus_live_syncMinAggregateOutputType = {
    shop_content: string | null
    last_change_at: Date | null
  }

  export type Ps_eventbus_live_syncMaxAggregateOutputType = {
    shop_content: string | null
    last_change_at: Date | null
  }

  export type Ps_eventbus_live_syncCountAggregateOutputType = {
    shop_content: number
    last_change_at: number
    _all: number
  }


  export type Ps_eventbus_live_syncMinAggregateInputType = {
    shop_content?: true
    last_change_at?: true
  }

  export type Ps_eventbus_live_syncMaxAggregateInputType = {
    shop_content?: true
    last_change_at?: true
  }

  export type Ps_eventbus_live_syncCountAggregateInputType = {
    shop_content?: true
    last_change_at?: true
    _all?: true
  }

  export type Ps_eventbus_live_syncAggregateArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Filter which ps_eventbus_live_sync to aggregate.
     */
    where?: ps_eventbus_live_syncWhereInput
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/sorting Sorting Docs}
     * 
     * Determine the order of ps_eventbus_live_syncs to fetch.
     */
    orderBy?: ps_eventbus_live_syncOrderByWithRelationInput | ps_eventbus_live_syncOrderByWithRelationInput[]
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination#cursor-based-pagination Cursor Docs}
     * 
     * Sets the start position
     */
    cursor?: ps_eventbus_live_syncWhereUniqueInput
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination Pagination Docs}
     * 
     * Take `±n` ps_eventbus_live_syncs from the position of the cursor.
     */
    take?: number
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination Pagination Docs}
     * 
     * Skip the first `n` ps_eventbus_live_syncs.
     */
    skip?: number
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/aggregations Aggregation Docs}
     * 
     * Count returned ps_eventbus_live_syncs
    **/
    _count?: true | Ps_eventbus_live_syncCountAggregateInputType
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/aggregations Aggregation Docs}
     * 
     * Select which fields to find the minimum value
    **/
    _min?: Ps_eventbus_live_syncMinAggregateInputType
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/aggregations Aggregation Docs}
     * 
     * Select which fields to find the maximum value
    **/
    _max?: Ps_eventbus_live_syncMaxAggregateInputType
  }

  export type GetPs_eventbus_live_syncAggregateType<T extends Ps_eventbus_live_syncAggregateArgs> = {
        [P in keyof T & keyof AggregatePs_eventbus_live_sync]: P extends '_count' | 'count'
      ? T[P] extends true
        ? number
        : GetScalarType<T[P], AggregatePs_eventbus_live_sync[P]>
      : GetScalarType<T[P], AggregatePs_eventbus_live_sync[P]>
  }




  export type ps_eventbus_live_syncGroupByArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    where?: ps_eventbus_live_syncWhereInput
    orderBy?: ps_eventbus_live_syncOrderByWithAggregationInput | ps_eventbus_live_syncOrderByWithAggregationInput[]
    by: Ps_eventbus_live_syncScalarFieldEnum[] | Ps_eventbus_live_syncScalarFieldEnum
    having?: ps_eventbus_live_syncScalarWhereWithAggregatesInput
    take?: number
    skip?: number
    _count?: Ps_eventbus_live_syncCountAggregateInputType | true
    _min?: Ps_eventbus_live_syncMinAggregateInputType
    _max?: Ps_eventbus_live_syncMaxAggregateInputType
  }

  export type Ps_eventbus_live_syncGroupByOutputType = {
    shop_content: string
    last_change_at: Date
    _count: Ps_eventbus_live_syncCountAggregateOutputType | null
    _min: Ps_eventbus_live_syncMinAggregateOutputType | null
    _max: Ps_eventbus_live_syncMaxAggregateOutputType | null
  }

  type GetPs_eventbus_live_syncGroupByPayload<T extends ps_eventbus_live_syncGroupByArgs> = Prisma.PrismaPromise<
    Array<
      PickEnumerable<Ps_eventbus_live_syncGroupByOutputType, T['by']> &
        {
          [P in ((keyof T) & (keyof Ps_eventbus_live_syncGroupByOutputType))]: P extends '_count'
            ? T[P] extends boolean
              ? number
              : GetScalarType<T[P], Ps_eventbus_live_syncGroupByOutputType[P]>
            : GetScalarType<T[P], Ps_eventbus_live_syncGroupByOutputType[P]>
        }
      >
    >


  export type ps_eventbus_live_syncSelect<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = $Extensions.GetSelect<{
    shop_content?: boolean
    last_change_at?: boolean
  }, ExtArgs["result"]["ps_eventbus_live_sync"]>



  export type ps_eventbus_live_syncSelectScalar = {
    shop_content?: boolean
    last_change_at?: boolean
  }

  export type ps_eventbus_live_syncOmit<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = $Extensions.GetOmit<"shop_content" | "last_change_at", ExtArgs["result"]["ps_eventbus_live_sync"]>

  export type $ps_eventbus_live_syncPayload<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    name: "ps_eventbus_live_sync"
    objects: {}
    scalars: $Extensions.GetPayloadResult<{
      shop_content: string
      last_change_at: Date
    }, ExtArgs["result"]["ps_eventbus_live_sync"]>
    composites: {}
  }

  type ps_eventbus_live_syncGetPayload<S extends boolean | null | undefined | ps_eventbus_live_syncDefaultArgs> = $Result.GetResult<Prisma.$ps_eventbus_live_syncPayload, S>

  type ps_eventbus_live_syncCountArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> =
    Omit<ps_eventbus_live_syncFindManyArgs, 'select' | 'include' | 'distinct' | 'omit'> & {
      select?: Ps_eventbus_live_syncCountAggregateInputType | true
    }

  export interface ps_eventbus_live_syncDelegate<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs, GlobalOmitOptions = {}> {
    [K: symbol]: { types: Prisma.TypeMap<ExtArgs>['model']['ps_eventbus_live_sync'], meta: { name: 'ps_eventbus_live_sync' } }
    /**
     * Find zero or one Ps_eventbus_live_sync that matches the filter.
     * @param {ps_eventbus_live_syncFindUniqueArgs} args - Arguments to find a Ps_eventbus_live_sync
     * @example
     * // Get one Ps_eventbus_live_sync
     * const ps_eventbus_live_sync = await prisma.ps_eventbus_live_sync.findUnique({
     *   where: {
     *     // ... provide filter here
     *   }
     * })
     */
    findUnique<T extends ps_eventbus_live_syncFindUniqueArgs>(args: SelectSubset<T, ps_eventbus_live_syncFindUniqueArgs<ExtArgs>>): Prisma__ps_eventbus_live_syncClient<$Result.GetResult<Prisma.$ps_eventbus_live_syncPayload<ExtArgs>, T, "findUnique", GlobalOmitOptions> | null, null, ExtArgs, GlobalOmitOptions>

    /**
     * Find one Ps_eventbus_live_sync that matches the filter or throw an error with `error.code='P2025'`
     * if no matches were found.
     * @param {ps_eventbus_live_syncFindUniqueOrThrowArgs} args - Arguments to find a Ps_eventbus_live_sync
     * @example
     * // Get one Ps_eventbus_live_sync
     * const ps_eventbus_live_sync = await prisma.ps_eventbus_live_sync.findUniqueOrThrow({
     *   where: {
     *     // ... provide filter here
     *   }
     * })
     */
    findUniqueOrThrow<T extends ps_eventbus_live_syncFindUniqueOrThrowArgs>(args: SelectSubset<T, ps_eventbus_live_syncFindUniqueOrThrowArgs<ExtArgs>>): Prisma__ps_eventbus_live_syncClient<$Result.GetResult<Prisma.$ps_eventbus_live_syncPayload<ExtArgs>, T, "findUniqueOrThrow", GlobalOmitOptions>, never, ExtArgs, GlobalOmitOptions>

    /**
     * Find the first Ps_eventbus_live_sync that matches the filter.
     * Note, that providing `undefined` is treated as the value not being there.
     * Read more here: https://pris.ly/d/null-undefined
     * @param {ps_eventbus_live_syncFindFirstArgs} args - Arguments to find a Ps_eventbus_live_sync
     * @example
     * // Get one Ps_eventbus_live_sync
     * const ps_eventbus_live_sync = await prisma.ps_eventbus_live_sync.findFirst({
     *   where: {
     *     // ... provide filter here
     *   }
     * })
     */
    findFirst<T extends ps_eventbus_live_syncFindFirstArgs>(args?: SelectSubset<T, ps_eventbus_live_syncFindFirstArgs<ExtArgs>>): Prisma__ps_eventbus_live_syncClient<$Result.GetResult<Prisma.$ps_eventbus_live_syncPayload<ExtArgs>, T, "findFirst", GlobalOmitOptions> | null, null, ExtArgs, GlobalOmitOptions>

    /**
     * Find the first Ps_eventbus_live_sync that matches the filter or
     * throw `PrismaKnownClientError` with `P2025` code if no matches were found.
     * Note, that providing `undefined` is treated as the value not being there.
     * Read more here: https://pris.ly/d/null-undefined
     * @param {ps_eventbus_live_syncFindFirstOrThrowArgs} args - Arguments to find a Ps_eventbus_live_sync
     * @example
     * // Get one Ps_eventbus_live_sync
     * const ps_eventbus_live_sync = await prisma.ps_eventbus_live_sync.findFirstOrThrow({
     *   where: {
     *     // ... provide filter here
     *   }
     * })
     */
    findFirstOrThrow<T extends ps_eventbus_live_syncFindFirstOrThrowArgs>(args?: SelectSubset<T, ps_eventbus_live_syncFindFirstOrThrowArgs<ExtArgs>>): Prisma__ps_eventbus_live_syncClient<$Result.GetResult<Prisma.$ps_eventbus_live_syncPayload<ExtArgs>, T, "findFirstOrThrow", GlobalOmitOptions>, never, ExtArgs, GlobalOmitOptions>

    /**
     * Find zero or more Ps_eventbus_live_syncs that matches the filter.
     * Note, that providing `undefined` is treated as the value not being there.
     * Read more here: https://pris.ly/d/null-undefined
     * @param {ps_eventbus_live_syncFindManyArgs} args - Arguments to filter and select certain fields only.
     * @example
     * // Get all Ps_eventbus_live_syncs
     * const ps_eventbus_live_syncs = await prisma.ps_eventbus_live_sync.findMany()
     * 
     * // Get first 10 Ps_eventbus_live_syncs
     * const ps_eventbus_live_syncs = await prisma.ps_eventbus_live_sync.findMany({ take: 10 })
     * 
     * // Only select the `shop_content`
     * const ps_eventbus_live_syncWithShop_contentOnly = await prisma.ps_eventbus_live_sync.findMany({ select: { shop_content: true } })
     * 
     */
    findMany<T extends ps_eventbus_live_syncFindManyArgs>(args?: SelectSubset<T, ps_eventbus_live_syncFindManyArgs<ExtArgs>>): Prisma.PrismaPromise<$Result.GetResult<Prisma.$ps_eventbus_live_syncPayload<ExtArgs>, T, "findMany", GlobalOmitOptions>>

    /**
     * Create a Ps_eventbus_live_sync.
     * @param {ps_eventbus_live_syncCreateArgs} args - Arguments to create a Ps_eventbus_live_sync.
     * @example
     * // Create one Ps_eventbus_live_sync
     * const Ps_eventbus_live_sync = await prisma.ps_eventbus_live_sync.create({
     *   data: {
     *     // ... data to create a Ps_eventbus_live_sync
     *   }
     * })
     * 
     */
    create<T extends ps_eventbus_live_syncCreateArgs>(args: SelectSubset<T, ps_eventbus_live_syncCreateArgs<ExtArgs>>): Prisma__ps_eventbus_live_syncClient<$Result.GetResult<Prisma.$ps_eventbus_live_syncPayload<ExtArgs>, T, "create", GlobalOmitOptions>, never, ExtArgs, GlobalOmitOptions>

    /**
     * Create many Ps_eventbus_live_syncs.
     * @param {ps_eventbus_live_syncCreateManyArgs} args - Arguments to create many Ps_eventbus_live_syncs.
     * @example
     * // Create many Ps_eventbus_live_syncs
     * const ps_eventbus_live_sync = await prisma.ps_eventbus_live_sync.createMany({
     *   data: [
     *     // ... provide data here
     *   ]
     * })
     *     
     */
    createMany<T extends ps_eventbus_live_syncCreateManyArgs>(args?: SelectSubset<T, ps_eventbus_live_syncCreateManyArgs<ExtArgs>>): Prisma.PrismaPromise<BatchPayload>

    /**
     * Delete a Ps_eventbus_live_sync.
     * @param {ps_eventbus_live_syncDeleteArgs} args - Arguments to delete one Ps_eventbus_live_sync.
     * @example
     * // Delete one Ps_eventbus_live_sync
     * const Ps_eventbus_live_sync = await prisma.ps_eventbus_live_sync.delete({
     *   where: {
     *     // ... filter to delete one Ps_eventbus_live_sync
     *   }
     * })
     * 
     */
    delete<T extends ps_eventbus_live_syncDeleteArgs>(args: SelectSubset<T, ps_eventbus_live_syncDeleteArgs<ExtArgs>>): Prisma__ps_eventbus_live_syncClient<$Result.GetResult<Prisma.$ps_eventbus_live_syncPayload<ExtArgs>, T, "delete", GlobalOmitOptions>, never, ExtArgs, GlobalOmitOptions>

    /**
     * Update one Ps_eventbus_live_sync.
     * @param {ps_eventbus_live_syncUpdateArgs} args - Arguments to update one Ps_eventbus_live_sync.
     * @example
     * // Update one Ps_eventbus_live_sync
     * const ps_eventbus_live_sync = await prisma.ps_eventbus_live_sync.update({
     *   where: {
     *     // ... provide filter here
     *   },
     *   data: {
     *     // ... provide data here
     *   }
     * })
     * 
     */
    update<T extends ps_eventbus_live_syncUpdateArgs>(args: SelectSubset<T, ps_eventbus_live_syncUpdateArgs<ExtArgs>>): Prisma__ps_eventbus_live_syncClient<$Result.GetResult<Prisma.$ps_eventbus_live_syncPayload<ExtArgs>, T, "update", GlobalOmitOptions>, never, ExtArgs, GlobalOmitOptions>

    /**
     * Delete zero or more Ps_eventbus_live_syncs.
     * @param {ps_eventbus_live_syncDeleteManyArgs} args - Arguments to filter Ps_eventbus_live_syncs to delete.
     * @example
     * // Delete a few Ps_eventbus_live_syncs
     * const { count } = await prisma.ps_eventbus_live_sync.deleteMany({
     *   where: {
     *     // ... provide filter here
     *   }
     * })
     * 
     */
    deleteMany<T extends ps_eventbus_live_syncDeleteManyArgs>(args?: SelectSubset<T, ps_eventbus_live_syncDeleteManyArgs<ExtArgs>>): Prisma.PrismaPromise<BatchPayload>

    /**
     * Update zero or more Ps_eventbus_live_syncs.
     * Note, that providing `undefined` is treated as the value not being there.
     * Read more here: https://pris.ly/d/null-undefined
     * @param {ps_eventbus_live_syncUpdateManyArgs} args - Arguments to update one or more rows.
     * @example
     * // Update many Ps_eventbus_live_syncs
     * const ps_eventbus_live_sync = await prisma.ps_eventbus_live_sync.updateMany({
     *   where: {
     *     // ... provide filter here
     *   },
     *   data: {
     *     // ... provide data here
     *   }
     * })
     * 
     */
    updateMany<T extends ps_eventbus_live_syncUpdateManyArgs>(args: SelectSubset<T, ps_eventbus_live_syncUpdateManyArgs<ExtArgs>>): Prisma.PrismaPromise<BatchPayload>

    /**
     * Create or update one Ps_eventbus_live_sync.
     * @param {ps_eventbus_live_syncUpsertArgs} args - Arguments to update or create a Ps_eventbus_live_sync.
     * @example
     * // Update or create a Ps_eventbus_live_sync
     * const ps_eventbus_live_sync = await prisma.ps_eventbus_live_sync.upsert({
     *   create: {
     *     // ... data to create a Ps_eventbus_live_sync
     *   },
     *   update: {
     *     // ... in case it already exists, update
     *   },
     *   where: {
     *     // ... the filter for the Ps_eventbus_live_sync we want to update
     *   }
     * })
     */
    upsert<T extends ps_eventbus_live_syncUpsertArgs>(args: SelectSubset<T, ps_eventbus_live_syncUpsertArgs<ExtArgs>>): Prisma__ps_eventbus_live_syncClient<$Result.GetResult<Prisma.$ps_eventbus_live_syncPayload<ExtArgs>, T, "upsert", GlobalOmitOptions>, never, ExtArgs, GlobalOmitOptions>


    /**
     * Count the number of Ps_eventbus_live_syncs.
     * Note, that providing `undefined` is treated as the value not being there.
     * Read more here: https://pris.ly/d/null-undefined
     * @param {ps_eventbus_live_syncCountArgs} args - Arguments to filter Ps_eventbus_live_syncs to count.
     * @example
     * // Count the number of Ps_eventbus_live_syncs
     * const count = await prisma.ps_eventbus_live_sync.count({
     *   where: {
     *     // ... the filter for the Ps_eventbus_live_syncs we want to count
     *   }
     * })
    **/
    count<T extends ps_eventbus_live_syncCountArgs>(
      args?: Subset<T, ps_eventbus_live_syncCountArgs>,
    ): Prisma.PrismaPromise<
      T extends $Utils.Record<'select', any>
        ? T['select'] extends true
          ? number
          : GetScalarType<T['select'], Ps_eventbus_live_syncCountAggregateOutputType>
        : number
    >

    /**
     * Allows you to perform aggregations operations on a Ps_eventbus_live_sync.
     * Note, that providing `undefined` is treated as the value not being there.
     * Read more here: https://pris.ly/d/null-undefined
     * @param {Ps_eventbus_live_syncAggregateArgs} args - Select which aggregations you would like to apply and on what fields.
     * @example
     * // Ordered by age ascending
     * // Where email contains prisma.io
     * // Limited to the 10 users
     * const aggregations = await prisma.user.aggregate({
     *   _avg: {
     *     age: true,
     *   },
     *   where: {
     *     email: {
     *       contains: "prisma.io",
     *     },
     *   },
     *   orderBy: {
     *     age: "asc",
     *   },
     *   take: 10,
     * })
    **/
    aggregate<T extends Ps_eventbus_live_syncAggregateArgs>(args: Subset<T, Ps_eventbus_live_syncAggregateArgs>): Prisma.PrismaPromise<GetPs_eventbus_live_syncAggregateType<T>>

    /**
     * Group by Ps_eventbus_live_sync.
     * Note, that providing `undefined` is treated as the value not being there.
     * Read more here: https://pris.ly/d/null-undefined
     * @param {ps_eventbus_live_syncGroupByArgs} args - Group by arguments.
     * @example
     * // Group by city, order by createdAt, get count
     * const result = await prisma.user.groupBy({
     *   by: ['city', 'createdAt'],
     *   orderBy: {
     *     createdAt: true
     *   },
     *   _count: {
     *     _all: true
     *   },
     * })
     * 
    **/
    groupBy<
      T extends ps_eventbus_live_syncGroupByArgs,
      HasSelectOrTake extends Or<
        Extends<'skip', Keys<T>>,
        Extends<'take', Keys<T>>
      >,
      OrderByArg extends True extends HasSelectOrTake
        ? { orderBy: ps_eventbus_live_syncGroupByArgs['orderBy'] }
        : { orderBy?: ps_eventbus_live_syncGroupByArgs['orderBy'] },
      OrderFields extends ExcludeUnderscoreKeys<Keys<MaybeTupleToUnion<T['orderBy']>>>,
      ByFields extends MaybeTupleToUnion<T['by']>,
      ByValid extends Has<ByFields, OrderFields>,
      HavingFields extends GetHavingFields<T['having']>,
      HavingValid extends Has<ByFields, HavingFields>,
      ByEmpty extends T['by'] extends never[] ? True : False,
      InputErrors extends ByEmpty extends True
      ? `Error: "by" must not be empty.`
      : HavingValid extends False
      ? {
          [P in HavingFields]: P extends ByFields
            ? never
            : P extends string
            ? `Error: Field "${P}" used in "having" needs to be provided in "by".`
            : [
                Error,
                'Field ',
                P,
                ` in "having" needs to be provided in "by"`,
              ]
        }[HavingFields]
      : 'take' extends Keys<T>
      ? 'orderBy' extends Keys<T>
        ? ByValid extends True
          ? {}
          : {
              [P in OrderFields]: P extends ByFields
                ? never
                : `Error: Field "${P}" in "orderBy" needs to be provided in "by"`
            }[OrderFields]
        : 'Error: If you provide "take", you also need to provide "orderBy"'
      : 'skip' extends Keys<T>
      ? 'orderBy' extends Keys<T>
        ? ByValid extends True
          ? {}
          : {
              [P in OrderFields]: P extends ByFields
                ? never
                : `Error: Field "${P}" in "orderBy" needs to be provided in "by"`
            }[OrderFields]
        : 'Error: If you provide "skip", you also need to provide "orderBy"'
      : ByValid extends True
      ? {}
      : {
          [P in OrderFields]: P extends ByFields
            ? never
            : `Error: Field "${P}" in "orderBy" needs to be provided in "by"`
        }[OrderFields]
    >(args: SubsetIntersection<T, ps_eventbus_live_syncGroupByArgs, OrderByArg> & InputErrors): {} extends InputErrors ? GetPs_eventbus_live_syncGroupByPayload<T> : Prisma.PrismaPromise<InputErrors>
  /**
   * Fields of the ps_eventbus_live_sync model
   */
  readonly fields: ps_eventbus_live_syncFieldRefs;
  }

  /**
   * The delegate class that acts as a "Promise-like" for ps_eventbus_live_sync.
   * Why is this prefixed with `Prisma__`?
   * Because we want to prevent naming conflicts as mentioned in
   * https://github.com/prisma/prisma-client-js/issues/707
   */
  export interface Prisma__ps_eventbus_live_syncClient<T, Null = never, ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs, GlobalOmitOptions = {}> extends Prisma.PrismaPromise<T> {
    readonly [Symbol.toStringTag]: "PrismaPromise"
    /**
     * Attaches callbacks for the resolution and/or rejection of the Promise.
     * @param onfulfilled The callback to execute when the Promise is resolved.
     * @param onrejected The callback to execute when the Promise is rejected.
     * @returns A Promise for the completion of which ever callback is executed.
     */
    then<TResult1 = T, TResult2 = never>(onfulfilled?: ((value: T) => TResult1 | PromiseLike<TResult1>) | undefined | null, onrejected?: ((reason: any) => TResult2 | PromiseLike<TResult2>) | undefined | null): $Utils.JsPromise<TResult1 | TResult2>
    /**
     * Attaches a callback for only the rejection of the Promise.
     * @param onrejected The callback to execute when the Promise is rejected.
     * @returns A Promise for the completion of the callback.
     */
    catch<TResult = never>(onrejected?: ((reason: any) => TResult | PromiseLike<TResult>) | undefined | null): $Utils.JsPromise<T | TResult>
    /**
     * Attaches a callback that is invoked when the Promise is settled (fulfilled or rejected). The
     * resolved value cannot be modified from the callback.
     * @param onfinally The callback to execute when the Promise is settled (fulfilled or rejected).
     * @returns A Promise for the completion of the callback.
     */
    finally(onfinally?: (() => void) | undefined | null): $Utils.JsPromise<T>
  }




  /**
   * Fields of the ps_eventbus_live_sync model
   */
  interface ps_eventbus_live_syncFieldRefs {
    readonly shop_content: FieldRef<"ps_eventbus_live_sync", 'String'>
    readonly last_change_at: FieldRef<"ps_eventbus_live_sync", 'DateTime'>
  }
    

  // Custom InputTypes
  /**
   * ps_eventbus_live_sync findUnique
   */
  export type ps_eventbus_live_syncFindUniqueArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_eventbus_live_sync
     */
    select?: ps_eventbus_live_syncSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_eventbus_live_sync
     */
    omit?: ps_eventbus_live_syncOmit<ExtArgs> | null
    /**
     * Filter, which ps_eventbus_live_sync to fetch.
     */
    where: ps_eventbus_live_syncWhereUniqueInput
  }

  /**
   * ps_eventbus_live_sync findUniqueOrThrow
   */
  export type ps_eventbus_live_syncFindUniqueOrThrowArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_eventbus_live_sync
     */
    select?: ps_eventbus_live_syncSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_eventbus_live_sync
     */
    omit?: ps_eventbus_live_syncOmit<ExtArgs> | null
    /**
     * Filter, which ps_eventbus_live_sync to fetch.
     */
    where: ps_eventbus_live_syncWhereUniqueInput
  }

  /**
   * ps_eventbus_live_sync findFirst
   */
  export type ps_eventbus_live_syncFindFirstArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_eventbus_live_sync
     */
    select?: ps_eventbus_live_syncSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_eventbus_live_sync
     */
    omit?: ps_eventbus_live_syncOmit<ExtArgs> | null
    /**
     * Filter, which ps_eventbus_live_sync to fetch.
     */
    where?: ps_eventbus_live_syncWhereInput
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/sorting Sorting Docs}
     * 
     * Determine the order of ps_eventbus_live_syncs to fetch.
     */
    orderBy?: ps_eventbus_live_syncOrderByWithRelationInput | ps_eventbus_live_syncOrderByWithRelationInput[]
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination#cursor-based-pagination Cursor Docs}
     * 
     * Sets the position for searching for ps_eventbus_live_syncs.
     */
    cursor?: ps_eventbus_live_syncWhereUniqueInput
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination Pagination Docs}
     * 
     * Take `±n` ps_eventbus_live_syncs from the position of the cursor.
     */
    take?: number
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination Pagination Docs}
     * 
     * Skip the first `n` ps_eventbus_live_syncs.
     */
    skip?: number
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/distinct Distinct Docs}
     * 
     * Filter by unique combinations of ps_eventbus_live_syncs.
     */
    distinct?: Ps_eventbus_live_syncScalarFieldEnum | Ps_eventbus_live_syncScalarFieldEnum[]
  }

  /**
   * ps_eventbus_live_sync findFirstOrThrow
   */
  export type ps_eventbus_live_syncFindFirstOrThrowArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_eventbus_live_sync
     */
    select?: ps_eventbus_live_syncSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_eventbus_live_sync
     */
    omit?: ps_eventbus_live_syncOmit<ExtArgs> | null
    /**
     * Filter, which ps_eventbus_live_sync to fetch.
     */
    where?: ps_eventbus_live_syncWhereInput
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/sorting Sorting Docs}
     * 
     * Determine the order of ps_eventbus_live_syncs to fetch.
     */
    orderBy?: ps_eventbus_live_syncOrderByWithRelationInput | ps_eventbus_live_syncOrderByWithRelationInput[]
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination#cursor-based-pagination Cursor Docs}
     * 
     * Sets the position for searching for ps_eventbus_live_syncs.
     */
    cursor?: ps_eventbus_live_syncWhereUniqueInput
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination Pagination Docs}
     * 
     * Take `±n` ps_eventbus_live_syncs from the position of the cursor.
     */
    take?: number
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination Pagination Docs}
     * 
     * Skip the first `n` ps_eventbus_live_syncs.
     */
    skip?: number
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/distinct Distinct Docs}
     * 
     * Filter by unique combinations of ps_eventbus_live_syncs.
     */
    distinct?: Ps_eventbus_live_syncScalarFieldEnum | Ps_eventbus_live_syncScalarFieldEnum[]
  }

  /**
   * ps_eventbus_live_sync findMany
   */
  export type ps_eventbus_live_syncFindManyArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_eventbus_live_sync
     */
    select?: ps_eventbus_live_syncSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_eventbus_live_sync
     */
    omit?: ps_eventbus_live_syncOmit<ExtArgs> | null
    /**
     * Filter, which ps_eventbus_live_syncs to fetch.
     */
    where?: ps_eventbus_live_syncWhereInput
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/sorting Sorting Docs}
     * 
     * Determine the order of ps_eventbus_live_syncs to fetch.
     */
    orderBy?: ps_eventbus_live_syncOrderByWithRelationInput | ps_eventbus_live_syncOrderByWithRelationInput[]
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination#cursor-based-pagination Cursor Docs}
     * 
     * Sets the position for listing ps_eventbus_live_syncs.
     */
    cursor?: ps_eventbus_live_syncWhereUniqueInput
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination Pagination Docs}
     * 
     * Take `±n` ps_eventbus_live_syncs from the position of the cursor.
     */
    take?: number
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination Pagination Docs}
     * 
     * Skip the first `n` ps_eventbus_live_syncs.
     */
    skip?: number
    distinct?: Ps_eventbus_live_syncScalarFieldEnum | Ps_eventbus_live_syncScalarFieldEnum[]
  }

  /**
   * ps_eventbus_live_sync create
   */
  export type ps_eventbus_live_syncCreateArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_eventbus_live_sync
     */
    select?: ps_eventbus_live_syncSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_eventbus_live_sync
     */
    omit?: ps_eventbus_live_syncOmit<ExtArgs> | null
    /**
     * The data needed to create a ps_eventbus_live_sync.
     */
    data: XOR<ps_eventbus_live_syncCreateInput, ps_eventbus_live_syncUncheckedCreateInput>
  }

  /**
   * ps_eventbus_live_sync createMany
   */
  export type ps_eventbus_live_syncCreateManyArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * The data used to create many ps_eventbus_live_syncs.
     */
    data: ps_eventbus_live_syncCreateManyInput | ps_eventbus_live_syncCreateManyInput[]
    skipDuplicates?: boolean
  }

  /**
   * ps_eventbus_live_sync update
   */
  export type ps_eventbus_live_syncUpdateArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_eventbus_live_sync
     */
    select?: ps_eventbus_live_syncSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_eventbus_live_sync
     */
    omit?: ps_eventbus_live_syncOmit<ExtArgs> | null
    /**
     * The data needed to update a ps_eventbus_live_sync.
     */
    data: XOR<ps_eventbus_live_syncUpdateInput, ps_eventbus_live_syncUncheckedUpdateInput>
    /**
     * Choose, which ps_eventbus_live_sync to update.
     */
    where: ps_eventbus_live_syncWhereUniqueInput
  }

  /**
   * ps_eventbus_live_sync updateMany
   */
  export type ps_eventbus_live_syncUpdateManyArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * The data used to update ps_eventbus_live_syncs.
     */
    data: XOR<ps_eventbus_live_syncUpdateManyMutationInput, ps_eventbus_live_syncUncheckedUpdateManyInput>
    /**
     * Filter which ps_eventbus_live_syncs to update
     */
    where?: ps_eventbus_live_syncWhereInput
    /**
     * Limit how many ps_eventbus_live_syncs to update.
     */
    limit?: number
  }

  /**
   * ps_eventbus_live_sync upsert
   */
  export type ps_eventbus_live_syncUpsertArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_eventbus_live_sync
     */
    select?: ps_eventbus_live_syncSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_eventbus_live_sync
     */
    omit?: ps_eventbus_live_syncOmit<ExtArgs> | null
    /**
     * The filter to search for the ps_eventbus_live_sync to update in case it exists.
     */
    where: ps_eventbus_live_syncWhereUniqueInput
    /**
     * In case the ps_eventbus_live_sync found by the `where` argument doesn't exist, create a new ps_eventbus_live_sync with this data.
     */
    create: XOR<ps_eventbus_live_syncCreateInput, ps_eventbus_live_syncUncheckedCreateInput>
    /**
     * In case the ps_eventbus_live_sync was found with the provided `where` argument, update it with this data.
     */
    update: XOR<ps_eventbus_live_syncUpdateInput, ps_eventbus_live_syncUncheckedUpdateInput>
  }

  /**
   * ps_eventbus_live_sync delete
   */
  export type ps_eventbus_live_syncDeleteArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_eventbus_live_sync
     */
    select?: ps_eventbus_live_syncSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_eventbus_live_sync
     */
    omit?: ps_eventbus_live_syncOmit<ExtArgs> | null
    /**
     * Filter which ps_eventbus_live_sync to delete.
     */
    where: ps_eventbus_live_syncWhereUniqueInput
  }

  /**
   * ps_eventbus_live_sync deleteMany
   */
  export type ps_eventbus_live_syncDeleteManyArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Filter which ps_eventbus_live_syncs to delete
     */
    where?: ps_eventbus_live_syncWhereInput
    /**
     * Limit how many ps_eventbus_live_syncs to delete.
     */
    limit?: number
  }

  /**
   * ps_eventbus_live_sync without action
   */
  export type ps_eventbus_live_syncDefaultArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_eventbus_live_sync
     */
    select?: ps_eventbus_live_syncSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_eventbus_live_sync
     */
    omit?: ps_eventbus_live_syncOmit<ExtArgs> | null
  }


  /**
   * Model ps_eventbus_type_sync
   */

  export type AggregatePs_eventbus_type_sync = {
    _count: Ps_eventbus_type_syncCountAggregateOutputType | null
    _avg: Ps_eventbus_type_syncAvgAggregateOutputType | null
    _sum: Ps_eventbus_type_syncSumAggregateOutputType | null
    _min: Ps_eventbus_type_syncMinAggregateOutputType | null
    _max: Ps_eventbus_type_syncMaxAggregateOutputType | null
  }

  export type Ps_eventbus_type_syncAvgAggregateOutputType = {
    offset: number | null
    id_shop: number | null
  }

  export type Ps_eventbus_type_syncSumAggregateOutputType = {
    offset: number | null
    id_shop: number | null
  }

  export type Ps_eventbus_type_syncMinAggregateOutputType = {
    type: string | null
    offset: number | null
    id_shop: number | null
    lang_iso: string | null
    full_sync_finished: boolean | null
    last_sync_date: Date | null
  }

  export type Ps_eventbus_type_syncMaxAggregateOutputType = {
    type: string | null
    offset: number | null
    id_shop: number | null
    lang_iso: string | null
    full_sync_finished: boolean | null
    last_sync_date: Date | null
  }

  export type Ps_eventbus_type_syncCountAggregateOutputType = {
    type: number
    offset: number
    id_shop: number
    lang_iso: number
    full_sync_finished: number
    last_sync_date: number
    _all: number
  }


  export type Ps_eventbus_type_syncAvgAggregateInputType = {
    offset?: true
    id_shop?: true
  }

  export type Ps_eventbus_type_syncSumAggregateInputType = {
    offset?: true
    id_shop?: true
  }

  export type Ps_eventbus_type_syncMinAggregateInputType = {
    type?: true
    offset?: true
    id_shop?: true
    lang_iso?: true
    full_sync_finished?: true
    last_sync_date?: true
  }

  export type Ps_eventbus_type_syncMaxAggregateInputType = {
    type?: true
    offset?: true
    id_shop?: true
    lang_iso?: true
    full_sync_finished?: true
    last_sync_date?: true
  }

  export type Ps_eventbus_type_syncCountAggregateInputType = {
    type?: true
    offset?: true
    id_shop?: true
    lang_iso?: true
    full_sync_finished?: true
    last_sync_date?: true
    _all?: true
  }

  export type Ps_eventbus_type_syncAggregateArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Filter which ps_eventbus_type_sync to aggregate.
     */
    where?: ps_eventbus_type_syncWhereInput
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/sorting Sorting Docs}
     * 
     * Determine the order of ps_eventbus_type_syncs to fetch.
     */
    orderBy?: ps_eventbus_type_syncOrderByWithRelationInput | ps_eventbus_type_syncOrderByWithRelationInput[]
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination#cursor-based-pagination Cursor Docs}
     * 
     * Sets the start position
     */
    cursor?: ps_eventbus_type_syncWhereUniqueInput
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination Pagination Docs}
     * 
     * Take `±n` ps_eventbus_type_syncs from the position of the cursor.
     */
    take?: number
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination Pagination Docs}
     * 
     * Skip the first `n` ps_eventbus_type_syncs.
     */
    skip?: number
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/aggregations Aggregation Docs}
     * 
     * Count returned ps_eventbus_type_syncs
    **/
    _count?: true | Ps_eventbus_type_syncCountAggregateInputType
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/aggregations Aggregation Docs}
     * 
     * Select which fields to average
    **/
    _avg?: Ps_eventbus_type_syncAvgAggregateInputType
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/aggregations Aggregation Docs}
     * 
     * Select which fields to sum
    **/
    _sum?: Ps_eventbus_type_syncSumAggregateInputType
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/aggregations Aggregation Docs}
     * 
     * Select which fields to find the minimum value
    **/
    _min?: Ps_eventbus_type_syncMinAggregateInputType
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/aggregations Aggregation Docs}
     * 
     * Select which fields to find the maximum value
    **/
    _max?: Ps_eventbus_type_syncMaxAggregateInputType
  }

  export type GetPs_eventbus_type_syncAggregateType<T extends Ps_eventbus_type_syncAggregateArgs> = {
        [P in keyof T & keyof AggregatePs_eventbus_type_sync]: P extends '_count' | 'count'
      ? T[P] extends true
        ? number
        : GetScalarType<T[P], AggregatePs_eventbus_type_sync[P]>
      : GetScalarType<T[P], AggregatePs_eventbus_type_sync[P]>
  }




  export type ps_eventbus_type_syncGroupByArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    where?: ps_eventbus_type_syncWhereInput
    orderBy?: ps_eventbus_type_syncOrderByWithAggregationInput | ps_eventbus_type_syncOrderByWithAggregationInput[]
    by: Ps_eventbus_type_syncScalarFieldEnum[] | Ps_eventbus_type_syncScalarFieldEnum
    having?: ps_eventbus_type_syncScalarWhereWithAggregatesInput
    take?: number
    skip?: number
    _count?: Ps_eventbus_type_syncCountAggregateInputType | true
    _avg?: Ps_eventbus_type_syncAvgAggregateInputType
    _sum?: Ps_eventbus_type_syncSumAggregateInputType
    _min?: Ps_eventbus_type_syncMinAggregateInputType
    _max?: Ps_eventbus_type_syncMaxAggregateInputType
  }

  export type Ps_eventbus_type_syncGroupByOutputType = {
    type: string
    offset: number
    id_shop: number
    lang_iso: string
    full_sync_finished: boolean
    last_sync_date: Date
    _count: Ps_eventbus_type_syncCountAggregateOutputType | null
    _avg: Ps_eventbus_type_syncAvgAggregateOutputType | null
    _sum: Ps_eventbus_type_syncSumAggregateOutputType | null
    _min: Ps_eventbus_type_syncMinAggregateOutputType | null
    _max: Ps_eventbus_type_syncMaxAggregateOutputType | null
  }

  type GetPs_eventbus_type_syncGroupByPayload<T extends ps_eventbus_type_syncGroupByArgs> = Prisma.PrismaPromise<
    Array<
      PickEnumerable<Ps_eventbus_type_syncGroupByOutputType, T['by']> &
        {
          [P in ((keyof T) & (keyof Ps_eventbus_type_syncGroupByOutputType))]: P extends '_count'
            ? T[P] extends boolean
              ? number
              : GetScalarType<T[P], Ps_eventbus_type_syncGroupByOutputType[P]>
            : GetScalarType<T[P], Ps_eventbus_type_syncGroupByOutputType[P]>
        }
      >
    >


  export type ps_eventbus_type_syncSelect<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = $Extensions.GetSelect<{
    type?: boolean
    offset?: boolean
    id_shop?: boolean
    lang_iso?: boolean
    full_sync_finished?: boolean
    last_sync_date?: boolean
  }, ExtArgs["result"]["ps_eventbus_type_sync"]>



  export type ps_eventbus_type_syncSelectScalar = {
    type?: boolean
    offset?: boolean
    id_shop?: boolean
    lang_iso?: boolean
    full_sync_finished?: boolean
    last_sync_date?: boolean
  }

  export type ps_eventbus_type_syncOmit<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = $Extensions.GetOmit<"type" | "offset" | "id_shop" | "lang_iso" | "full_sync_finished" | "last_sync_date", ExtArgs["result"]["ps_eventbus_type_sync"]>

  export type $ps_eventbus_type_syncPayload<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    name: "ps_eventbus_type_sync"
    objects: {}
    scalars: $Extensions.GetPayloadResult<{
      type: string
      offset: number
      id_shop: number
      lang_iso: string
      full_sync_finished: boolean
      last_sync_date: Date
    }, ExtArgs["result"]["ps_eventbus_type_sync"]>
    composites: {}
  }

  type ps_eventbus_type_syncGetPayload<S extends boolean | null | undefined | ps_eventbus_type_syncDefaultArgs> = $Result.GetResult<Prisma.$ps_eventbus_type_syncPayload, S>

  type ps_eventbus_type_syncCountArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> =
    Omit<ps_eventbus_type_syncFindManyArgs, 'select' | 'include' | 'distinct' | 'omit'> & {
      select?: Ps_eventbus_type_syncCountAggregateInputType | true
    }

  export interface ps_eventbus_type_syncDelegate<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs, GlobalOmitOptions = {}> {
    [K: symbol]: { types: Prisma.TypeMap<ExtArgs>['model']['ps_eventbus_type_sync'], meta: { name: 'ps_eventbus_type_sync' } }
    /**
     * Find zero or one Ps_eventbus_type_sync that matches the filter.
     * @param {ps_eventbus_type_syncFindUniqueArgs} args - Arguments to find a Ps_eventbus_type_sync
     * @example
     * // Get one Ps_eventbus_type_sync
     * const ps_eventbus_type_sync = await prisma.ps_eventbus_type_sync.findUnique({
     *   where: {
     *     // ... provide filter here
     *   }
     * })
     */
    findUnique<T extends ps_eventbus_type_syncFindUniqueArgs>(args: SelectSubset<T, ps_eventbus_type_syncFindUniqueArgs<ExtArgs>>): Prisma__ps_eventbus_type_syncClient<$Result.GetResult<Prisma.$ps_eventbus_type_syncPayload<ExtArgs>, T, "findUnique", GlobalOmitOptions> | null, null, ExtArgs, GlobalOmitOptions>

    /**
     * Find one Ps_eventbus_type_sync that matches the filter or throw an error with `error.code='P2025'`
     * if no matches were found.
     * @param {ps_eventbus_type_syncFindUniqueOrThrowArgs} args - Arguments to find a Ps_eventbus_type_sync
     * @example
     * // Get one Ps_eventbus_type_sync
     * const ps_eventbus_type_sync = await prisma.ps_eventbus_type_sync.findUniqueOrThrow({
     *   where: {
     *     // ... provide filter here
     *   }
     * })
     */
    findUniqueOrThrow<T extends ps_eventbus_type_syncFindUniqueOrThrowArgs>(args: SelectSubset<T, ps_eventbus_type_syncFindUniqueOrThrowArgs<ExtArgs>>): Prisma__ps_eventbus_type_syncClient<$Result.GetResult<Prisma.$ps_eventbus_type_syncPayload<ExtArgs>, T, "findUniqueOrThrow", GlobalOmitOptions>, never, ExtArgs, GlobalOmitOptions>

    /**
     * Find the first Ps_eventbus_type_sync that matches the filter.
     * Note, that providing `undefined` is treated as the value not being there.
     * Read more here: https://pris.ly/d/null-undefined
     * @param {ps_eventbus_type_syncFindFirstArgs} args - Arguments to find a Ps_eventbus_type_sync
     * @example
     * // Get one Ps_eventbus_type_sync
     * const ps_eventbus_type_sync = await prisma.ps_eventbus_type_sync.findFirst({
     *   where: {
     *     // ... provide filter here
     *   }
     * })
     */
    findFirst<T extends ps_eventbus_type_syncFindFirstArgs>(args?: SelectSubset<T, ps_eventbus_type_syncFindFirstArgs<ExtArgs>>): Prisma__ps_eventbus_type_syncClient<$Result.GetResult<Prisma.$ps_eventbus_type_syncPayload<ExtArgs>, T, "findFirst", GlobalOmitOptions> | null, null, ExtArgs, GlobalOmitOptions>

    /**
     * Find the first Ps_eventbus_type_sync that matches the filter or
     * throw `PrismaKnownClientError` with `P2025` code if no matches were found.
     * Note, that providing `undefined` is treated as the value not being there.
     * Read more here: https://pris.ly/d/null-undefined
     * @param {ps_eventbus_type_syncFindFirstOrThrowArgs} args - Arguments to find a Ps_eventbus_type_sync
     * @example
     * // Get one Ps_eventbus_type_sync
     * const ps_eventbus_type_sync = await prisma.ps_eventbus_type_sync.findFirstOrThrow({
     *   where: {
     *     // ... provide filter here
     *   }
     * })
     */
    findFirstOrThrow<T extends ps_eventbus_type_syncFindFirstOrThrowArgs>(args?: SelectSubset<T, ps_eventbus_type_syncFindFirstOrThrowArgs<ExtArgs>>): Prisma__ps_eventbus_type_syncClient<$Result.GetResult<Prisma.$ps_eventbus_type_syncPayload<ExtArgs>, T, "findFirstOrThrow", GlobalOmitOptions>, never, ExtArgs, GlobalOmitOptions>

    /**
     * Find zero or more Ps_eventbus_type_syncs that matches the filter.
     * Note, that providing `undefined` is treated as the value not being there.
     * Read more here: https://pris.ly/d/null-undefined
     * @param {ps_eventbus_type_syncFindManyArgs} args - Arguments to filter and select certain fields only.
     * @example
     * // Get all Ps_eventbus_type_syncs
     * const ps_eventbus_type_syncs = await prisma.ps_eventbus_type_sync.findMany()
     * 
     * // Get first 10 Ps_eventbus_type_syncs
     * const ps_eventbus_type_syncs = await prisma.ps_eventbus_type_sync.findMany({ take: 10 })
     * 
     * // Only select the `type`
     * const ps_eventbus_type_syncWithTypeOnly = await prisma.ps_eventbus_type_sync.findMany({ select: { type: true } })
     * 
     */
    findMany<T extends ps_eventbus_type_syncFindManyArgs>(args?: SelectSubset<T, ps_eventbus_type_syncFindManyArgs<ExtArgs>>): Prisma.PrismaPromise<$Result.GetResult<Prisma.$ps_eventbus_type_syncPayload<ExtArgs>, T, "findMany", GlobalOmitOptions>>

    /**
     * Create a Ps_eventbus_type_sync.
     * @param {ps_eventbus_type_syncCreateArgs} args - Arguments to create a Ps_eventbus_type_sync.
     * @example
     * // Create one Ps_eventbus_type_sync
     * const Ps_eventbus_type_sync = await prisma.ps_eventbus_type_sync.create({
     *   data: {
     *     // ... data to create a Ps_eventbus_type_sync
     *   }
     * })
     * 
     */
    create<T extends ps_eventbus_type_syncCreateArgs>(args: SelectSubset<T, ps_eventbus_type_syncCreateArgs<ExtArgs>>): Prisma__ps_eventbus_type_syncClient<$Result.GetResult<Prisma.$ps_eventbus_type_syncPayload<ExtArgs>, T, "create", GlobalOmitOptions>, never, ExtArgs, GlobalOmitOptions>

    /**
     * Create many Ps_eventbus_type_syncs.
     * @param {ps_eventbus_type_syncCreateManyArgs} args - Arguments to create many Ps_eventbus_type_syncs.
     * @example
     * // Create many Ps_eventbus_type_syncs
     * const ps_eventbus_type_sync = await prisma.ps_eventbus_type_sync.createMany({
     *   data: [
     *     // ... provide data here
     *   ]
     * })
     *     
     */
    createMany<T extends ps_eventbus_type_syncCreateManyArgs>(args?: SelectSubset<T, ps_eventbus_type_syncCreateManyArgs<ExtArgs>>): Prisma.PrismaPromise<BatchPayload>

    /**
     * Delete a Ps_eventbus_type_sync.
     * @param {ps_eventbus_type_syncDeleteArgs} args - Arguments to delete one Ps_eventbus_type_sync.
     * @example
     * // Delete one Ps_eventbus_type_sync
     * const Ps_eventbus_type_sync = await prisma.ps_eventbus_type_sync.delete({
     *   where: {
     *     // ... filter to delete one Ps_eventbus_type_sync
     *   }
     * })
     * 
     */
    delete<T extends ps_eventbus_type_syncDeleteArgs>(args: SelectSubset<T, ps_eventbus_type_syncDeleteArgs<ExtArgs>>): Prisma__ps_eventbus_type_syncClient<$Result.GetResult<Prisma.$ps_eventbus_type_syncPayload<ExtArgs>, T, "delete", GlobalOmitOptions>, never, ExtArgs, GlobalOmitOptions>

    /**
     * Update one Ps_eventbus_type_sync.
     * @param {ps_eventbus_type_syncUpdateArgs} args - Arguments to update one Ps_eventbus_type_sync.
     * @example
     * // Update one Ps_eventbus_type_sync
     * const ps_eventbus_type_sync = await prisma.ps_eventbus_type_sync.update({
     *   where: {
     *     // ... provide filter here
     *   },
     *   data: {
     *     // ... provide data here
     *   }
     * })
     * 
     */
    update<T extends ps_eventbus_type_syncUpdateArgs>(args: SelectSubset<T, ps_eventbus_type_syncUpdateArgs<ExtArgs>>): Prisma__ps_eventbus_type_syncClient<$Result.GetResult<Prisma.$ps_eventbus_type_syncPayload<ExtArgs>, T, "update", GlobalOmitOptions>, never, ExtArgs, GlobalOmitOptions>

    /**
     * Delete zero or more Ps_eventbus_type_syncs.
     * @param {ps_eventbus_type_syncDeleteManyArgs} args - Arguments to filter Ps_eventbus_type_syncs to delete.
     * @example
     * // Delete a few Ps_eventbus_type_syncs
     * const { count } = await prisma.ps_eventbus_type_sync.deleteMany({
     *   where: {
     *     // ... provide filter here
     *   }
     * })
     * 
     */
    deleteMany<T extends ps_eventbus_type_syncDeleteManyArgs>(args?: SelectSubset<T, ps_eventbus_type_syncDeleteManyArgs<ExtArgs>>): Prisma.PrismaPromise<BatchPayload>

    /**
     * Update zero or more Ps_eventbus_type_syncs.
     * Note, that providing `undefined` is treated as the value not being there.
     * Read more here: https://pris.ly/d/null-undefined
     * @param {ps_eventbus_type_syncUpdateManyArgs} args - Arguments to update one or more rows.
     * @example
     * // Update many Ps_eventbus_type_syncs
     * const ps_eventbus_type_sync = await prisma.ps_eventbus_type_sync.updateMany({
     *   where: {
     *     // ... provide filter here
     *   },
     *   data: {
     *     // ... provide data here
     *   }
     * })
     * 
     */
    updateMany<T extends ps_eventbus_type_syncUpdateManyArgs>(args: SelectSubset<T, ps_eventbus_type_syncUpdateManyArgs<ExtArgs>>): Prisma.PrismaPromise<BatchPayload>

    /**
     * Create or update one Ps_eventbus_type_sync.
     * @param {ps_eventbus_type_syncUpsertArgs} args - Arguments to update or create a Ps_eventbus_type_sync.
     * @example
     * // Update or create a Ps_eventbus_type_sync
     * const ps_eventbus_type_sync = await prisma.ps_eventbus_type_sync.upsert({
     *   create: {
     *     // ... data to create a Ps_eventbus_type_sync
     *   },
     *   update: {
     *     // ... in case it already exists, update
     *   },
     *   where: {
     *     // ... the filter for the Ps_eventbus_type_sync we want to update
     *   }
     * })
     */
    upsert<T extends ps_eventbus_type_syncUpsertArgs>(args: SelectSubset<T, ps_eventbus_type_syncUpsertArgs<ExtArgs>>): Prisma__ps_eventbus_type_syncClient<$Result.GetResult<Prisma.$ps_eventbus_type_syncPayload<ExtArgs>, T, "upsert", GlobalOmitOptions>, never, ExtArgs, GlobalOmitOptions>


    /**
     * Count the number of Ps_eventbus_type_syncs.
     * Note, that providing `undefined` is treated as the value not being there.
     * Read more here: https://pris.ly/d/null-undefined
     * @param {ps_eventbus_type_syncCountArgs} args - Arguments to filter Ps_eventbus_type_syncs to count.
     * @example
     * // Count the number of Ps_eventbus_type_syncs
     * const count = await prisma.ps_eventbus_type_sync.count({
     *   where: {
     *     // ... the filter for the Ps_eventbus_type_syncs we want to count
     *   }
     * })
    **/
    count<T extends ps_eventbus_type_syncCountArgs>(
      args?: Subset<T, ps_eventbus_type_syncCountArgs>,
    ): Prisma.PrismaPromise<
      T extends $Utils.Record<'select', any>
        ? T['select'] extends true
          ? number
          : GetScalarType<T['select'], Ps_eventbus_type_syncCountAggregateOutputType>
        : number
    >

    /**
     * Allows you to perform aggregations operations on a Ps_eventbus_type_sync.
     * Note, that providing `undefined` is treated as the value not being there.
     * Read more here: https://pris.ly/d/null-undefined
     * @param {Ps_eventbus_type_syncAggregateArgs} args - Select which aggregations you would like to apply and on what fields.
     * @example
     * // Ordered by age ascending
     * // Where email contains prisma.io
     * // Limited to the 10 users
     * const aggregations = await prisma.user.aggregate({
     *   _avg: {
     *     age: true,
     *   },
     *   where: {
     *     email: {
     *       contains: "prisma.io",
     *     },
     *   },
     *   orderBy: {
     *     age: "asc",
     *   },
     *   take: 10,
     * })
    **/
    aggregate<T extends Ps_eventbus_type_syncAggregateArgs>(args: Subset<T, Ps_eventbus_type_syncAggregateArgs>): Prisma.PrismaPromise<GetPs_eventbus_type_syncAggregateType<T>>

    /**
     * Group by Ps_eventbus_type_sync.
     * Note, that providing `undefined` is treated as the value not being there.
     * Read more here: https://pris.ly/d/null-undefined
     * @param {ps_eventbus_type_syncGroupByArgs} args - Group by arguments.
     * @example
     * // Group by city, order by createdAt, get count
     * const result = await prisma.user.groupBy({
     *   by: ['city', 'createdAt'],
     *   orderBy: {
     *     createdAt: true
     *   },
     *   _count: {
     *     _all: true
     *   },
     * })
     * 
    **/
    groupBy<
      T extends ps_eventbus_type_syncGroupByArgs,
      HasSelectOrTake extends Or<
        Extends<'skip', Keys<T>>,
        Extends<'take', Keys<T>>
      >,
      OrderByArg extends True extends HasSelectOrTake
        ? { orderBy: ps_eventbus_type_syncGroupByArgs['orderBy'] }
        : { orderBy?: ps_eventbus_type_syncGroupByArgs['orderBy'] },
      OrderFields extends ExcludeUnderscoreKeys<Keys<MaybeTupleToUnion<T['orderBy']>>>,
      ByFields extends MaybeTupleToUnion<T['by']>,
      ByValid extends Has<ByFields, OrderFields>,
      HavingFields extends GetHavingFields<T['having']>,
      HavingValid extends Has<ByFields, HavingFields>,
      ByEmpty extends T['by'] extends never[] ? True : False,
      InputErrors extends ByEmpty extends True
      ? `Error: "by" must not be empty.`
      : HavingValid extends False
      ? {
          [P in HavingFields]: P extends ByFields
            ? never
            : P extends string
            ? `Error: Field "${P}" used in "having" needs to be provided in "by".`
            : [
                Error,
                'Field ',
                P,
                ` in "having" needs to be provided in "by"`,
              ]
        }[HavingFields]
      : 'take' extends Keys<T>
      ? 'orderBy' extends Keys<T>
        ? ByValid extends True
          ? {}
          : {
              [P in OrderFields]: P extends ByFields
                ? never
                : `Error: Field "${P}" in "orderBy" needs to be provided in "by"`
            }[OrderFields]
        : 'Error: If you provide "take", you also need to provide "orderBy"'
      : 'skip' extends Keys<T>
      ? 'orderBy' extends Keys<T>
        ? ByValid extends True
          ? {}
          : {
              [P in OrderFields]: P extends ByFields
                ? never
                : `Error: Field "${P}" in "orderBy" needs to be provided in "by"`
            }[OrderFields]
        : 'Error: If you provide "skip", you also need to provide "orderBy"'
      : ByValid extends True
      ? {}
      : {
          [P in OrderFields]: P extends ByFields
            ? never
            : `Error: Field "${P}" in "orderBy" needs to be provided in "by"`
        }[OrderFields]
    >(args: SubsetIntersection<T, ps_eventbus_type_syncGroupByArgs, OrderByArg> & InputErrors): {} extends InputErrors ? GetPs_eventbus_type_syncGroupByPayload<T> : Prisma.PrismaPromise<InputErrors>
  /**
   * Fields of the ps_eventbus_type_sync model
   */
  readonly fields: ps_eventbus_type_syncFieldRefs;
  }

  /**
   * The delegate class that acts as a "Promise-like" for ps_eventbus_type_sync.
   * Why is this prefixed with `Prisma__`?
   * Because we want to prevent naming conflicts as mentioned in
   * https://github.com/prisma/prisma-client-js/issues/707
   */
  export interface Prisma__ps_eventbus_type_syncClient<T, Null = never, ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs, GlobalOmitOptions = {}> extends Prisma.PrismaPromise<T> {
    readonly [Symbol.toStringTag]: "PrismaPromise"
    /**
     * Attaches callbacks for the resolution and/or rejection of the Promise.
     * @param onfulfilled The callback to execute when the Promise is resolved.
     * @param onrejected The callback to execute when the Promise is rejected.
     * @returns A Promise for the completion of which ever callback is executed.
     */
    then<TResult1 = T, TResult2 = never>(onfulfilled?: ((value: T) => TResult1 | PromiseLike<TResult1>) | undefined | null, onrejected?: ((reason: any) => TResult2 | PromiseLike<TResult2>) | undefined | null): $Utils.JsPromise<TResult1 | TResult2>
    /**
     * Attaches a callback for only the rejection of the Promise.
     * @param onrejected The callback to execute when the Promise is rejected.
     * @returns A Promise for the completion of the callback.
     */
    catch<TResult = never>(onrejected?: ((reason: any) => TResult | PromiseLike<TResult>) | undefined | null): $Utils.JsPromise<T | TResult>
    /**
     * Attaches a callback that is invoked when the Promise is settled (fulfilled or rejected). The
     * resolved value cannot be modified from the callback.
     * @param onfinally The callback to execute when the Promise is settled (fulfilled or rejected).
     * @returns A Promise for the completion of the callback.
     */
    finally(onfinally?: (() => void) | undefined | null): $Utils.JsPromise<T>
  }




  /**
   * Fields of the ps_eventbus_type_sync model
   */
  interface ps_eventbus_type_syncFieldRefs {
    readonly type: FieldRef<"ps_eventbus_type_sync", 'String'>
    readonly offset: FieldRef<"ps_eventbus_type_sync", 'Int'>
    readonly id_shop: FieldRef<"ps_eventbus_type_sync", 'Int'>
    readonly lang_iso: FieldRef<"ps_eventbus_type_sync", 'String'>
    readonly full_sync_finished: FieldRef<"ps_eventbus_type_sync", 'Boolean'>
    readonly last_sync_date: FieldRef<"ps_eventbus_type_sync", 'DateTime'>
  }
    

  // Custom InputTypes
  /**
   * ps_eventbus_type_sync findUnique
   */
  export type ps_eventbus_type_syncFindUniqueArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_eventbus_type_sync
     */
    select?: ps_eventbus_type_syncSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_eventbus_type_sync
     */
    omit?: ps_eventbus_type_syncOmit<ExtArgs> | null
    /**
     * Filter, which ps_eventbus_type_sync to fetch.
     */
    where: ps_eventbus_type_syncWhereUniqueInput
  }

  /**
   * ps_eventbus_type_sync findUniqueOrThrow
   */
  export type ps_eventbus_type_syncFindUniqueOrThrowArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_eventbus_type_sync
     */
    select?: ps_eventbus_type_syncSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_eventbus_type_sync
     */
    omit?: ps_eventbus_type_syncOmit<ExtArgs> | null
    /**
     * Filter, which ps_eventbus_type_sync to fetch.
     */
    where: ps_eventbus_type_syncWhereUniqueInput
  }

  /**
   * ps_eventbus_type_sync findFirst
   */
  export type ps_eventbus_type_syncFindFirstArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_eventbus_type_sync
     */
    select?: ps_eventbus_type_syncSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_eventbus_type_sync
     */
    omit?: ps_eventbus_type_syncOmit<ExtArgs> | null
    /**
     * Filter, which ps_eventbus_type_sync to fetch.
     */
    where?: ps_eventbus_type_syncWhereInput
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/sorting Sorting Docs}
     * 
     * Determine the order of ps_eventbus_type_syncs to fetch.
     */
    orderBy?: ps_eventbus_type_syncOrderByWithRelationInput | ps_eventbus_type_syncOrderByWithRelationInput[]
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination#cursor-based-pagination Cursor Docs}
     * 
     * Sets the position for searching for ps_eventbus_type_syncs.
     */
    cursor?: ps_eventbus_type_syncWhereUniqueInput
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination Pagination Docs}
     * 
     * Take `±n` ps_eventbus_type_syncs from the position of the cursor.
     */
    take?: number
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination Pagination Docs}
     * 
     * Skip the first `n` ps_eventbus_type_syncs.
     */
    skip?: number
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/distinct Distinct Docs}
     * 
     * Filter by unique combinations of ps_eventbus_type_syncs.
     */
    distinct?: Ps_eventbus_type_syncScalarFieldEnum | Ps_eventbus_type_syncScalarFieldEnum[]
  }

  /**
   * ps_eventbus_type_sync findFirstOrThrow
   */
  export type ps_eventbus_type_syncFindFirstOrThrowArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_eventbus_type_sync
     */
    select?: ps_eventbus_type_syncSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_eventbus_type_sync
     */
    omit?: ps_eventbus_type_syncOmit<ExtArgs> | null
    /**
     * Filter, which ps_eventbus_type_sync to fetch.
     */
    where?: ps_eventbus_type_syncWhereInput
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/sorting Sorting Docs}
     * 
     * Determine the order of ps_eventbus_type_syncs to fetch.
     */
    orderBy?: ps_eventbus_type_syncOrderByWithRelationInput | ps_eventbus_type_syncOrderByWithRelationInput[]
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination#cursor-based-pagination Cursor Docs}
     * 
     * Sets the position for searching for ps_eventbus_type_syncs.
     */
    cursor?: ps_eventbus_type_syncWhereUniqueInput
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination Pagination Docs}
     * 
     * Take `±n` ps_eventbus_type_syncs from the position of the cursor.
     */
    take?: number
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination Pagination Docs}
     * 
     * Skip the first `n` ps_eventbus_type_syncs.
     */
    skip?: number
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/distinct Distinct Docs}
     * 
     * Filter by unique combinations of ps_eventbus_type_syncs.
     */
    distinct?: Ps_eventbus_type_syncScalarFieldEnum | Ps_eventbus_type_syncScalarFieldEnum[]
  }

  /**
   * ps_eventbus_type_sync findMany
   */
  export type ps_eventbus_type_syncFindManyArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_eventbus_type_sync
     */
    select?: ps_eventbus_type_syncSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_eventbus_type_sync
     */
    omit?: ps_eventbus_type_syncOmit<ExtArgs> | null
    /**
     * Filter, which ps_eventbus_type_syncs to fetch.
     */
    where?: ps_eventbus_type_syncWhereInput
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/sorting Sorting Docs}
     * 
     * Determine the order of ps_eventbus_type_syncs to fetch.
     */
    orderBy?: ps_eventbus_type_syncOrderByWithRelationInput | ps_eventbus_type_syncOrderByWithRelationInput[]
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination#cursor-based-pagination Cursor Docs}
     * 
     * Sets the position for listing ps_eventbus_type_syncs.
     */
    cursor?: ps_eventbus_type_syncWhereUniqueInput
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination Pagination Docs}
     * 
     * Take `±n` ps_eventbus_type_syncs from the position of the cursor.
     */
    take?: number
    /**
     * {@link https://www.prisma.io/docs/concepts/components/prisma-client/pagination Pagination Docs}
     * 
     * Skip the first `n` ps_eventbus_type_syncs.
     */
    skip?: number
    distinct?: Ps_eventbus_type_syncScalarFieldEnum | Ps_eventbus_type_syncScalarFieldEnum[]
  }

  /**
   * ps_eventbus_type_sync create
   */
  export type ps_eventbus_type_syncCreateArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_eventbus_type_sync
     */
    select?: ps_eventbus_type_syncSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_eventbus_type_sync
     */
    omit?: ps_eventbus_type_syncOmit<ExtArgs> | null
    /**
     * The data needed to create a ps_eventbus_type_sync.
     */
    data: XOR<ps_eventbus_type_syncCreateInput, ps_eventbus_type_syncUncheckedCreateInput>
  }

  /**
   * ps_eventbus_type_sync createMany
   */
  export type ps_eventbus_type_syncCreateManyArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * The data used to create many ps_eventbus_type_syncs.
     */
    data: ps_eventbus_type_syncCreateManyInput | ps_eventbus_type_syncCreateManyInput[]
    skipDuplicates?: boolean
  }

  /**
   * ps_eventbus_type_sync update
   */
  export type ps_eventbus_type_syncUpdateArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_eventbus_type_sync
     */
    select?: ps_eventbus_type_syncSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_eventbus_type_sync
     */
    omit?: ps_eventbus_type_syncOmit<ExtArgs> | null
    /**
     * The data needed to update a ps_eventbus_type_sync.
     */
    data: XOR<ps_eventbus_type_syncUpdateInput, ps_eventbus_type_syncUncheckedUpdateInput>
    /**
     * Choose, which ps_eventbus_type_sync to update.
     */
    where: ps_eventbus_type_syncWhereUniqueInput
  }

  /**
   * ps_eventbus_type_sync updateMany
   */
  export type ps_eventbus_type_syncUpdateManyArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * The data used to update ps_eventbus_type_syncs.
     */
    data: XOR<ps_eventbus_type_syncUpdateManyMutationInput, ps_eventbus_type_syncUncheckedUpdateManyInput>
    /**
     * Filter which ps_eventbus_type_syncs to update
     */
    where?: ps_eventbus_type_syncWhereInput
    /**
     * Limit how many ps_eventbus_type_syncs to update.
     */
    limit?: number
  }

  /**
   * ps_eventbus_type_sync upsert
   */
  export type ps_eventbus_type_syncUpsertArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_eventbus_type_sync
     */
    select?: ps_eventbus_type_syncSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_eventbus_type_sync
     */
    omit?: ps_eventbus_type_syncOmit<ExtArgs> | null
    /**
     * The filter to search for the ps_eventbus_type_sync to update in case it exists.
     */
    where: ps_eventbus_type_syncWhereUniqueInput
    /**
     * In case the ps_eventbus_type_sync found by the `where` argument doesn't exist, create a new ps_eventbus_type_sync with this data.
     */
    create: XOR<ps_eventbus_type_syncCreateInput, ps_eventbus_type_syncUncheckedCreateInput>
    /**
     * In case the ps_eventbus_type_sync was found with the provided `where` argument, update it with this data.
     */
    update: XOR<ps_eventbus_type_syncUpdateInput, ps_eventbus_type_syncUncheckedUpdateInput>
  }

  /**
   * ps_eventbus_type_sync delete
   */
  export type ps_eventbus_type_syncDeleteArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_eventbus_type_sync
     */
    select?: ps_eventbus_type_syncSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_eventbus_type_sync
     */
    omit?: ps_eventbus_type_syncOmit<ExtArgs> | null
    /**
     * Filter which ps_eventbus_type_sync to delete.
     */
    where: ps_eventbus_type_syncWhereUniqueInput
  }

  /**
   * ps_eventbus_type_sync deleteMany
   */
  export type ps_eventbus_type_syncDeleteManyArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Filter which ps_eventbus_type_syncs to delete
     */
    where?: ps_eventbus_type_syncWhereInput
    /**
     * Limit how many ps_eventbus_type_syncs to delete.
     */
    limit?: number
  }

  /**
   * ps_eventbus_type_sync without action
   */
  export type ps_eventbus_type_syncDefaultArgs<ExtArgs extends $Extensions.InternalArgs = $Extensions.DefaultArgs> = {
    /**
     * Select specific fields to fetch from the ps_eventbus_type_sync
     */
    select?: ps_eventbus_type_syncSelect<ExtArgs> | null
    /**
     * Omit specific fields from the ps_eventbus_type_sync
     */
    omit?: ps_eventbus_type_syncOmit<ExtArgs> | null
  }


  /**
   * Enums
   */

  export const TransactionIsolationLevel: {
    ReadUncommitted: 'ReadUncommitted',
    ReadCommitted: 'ReadCommitted',
    RepeatableRead: 'RepeatableRead',
    Serializable: 'Serializable'
  };

  export type TransactionIsolationLevel = (typeof TransactionIsolationLevel)[keyof typeof TransactionIsolationLevel]


  export const Ps_configurationScalarFieldEnum: {
    id_configuration: 'id_configuration',
    id_shop_group: 'id_shop_group',
    id_shop: 'id_shop',
    name: 'name',
    value: 'value',
    date_add: 'date_add',
    date_upd: 'date_upd'
  };

  export type Ps_configurationScalarFieldEnum = (typeof Ps_configurationScalarFieldEnum)[keyof typeof Ps_configurationScalarFieldEnum]


  export const Ps_eventbus_incremental_syncScalarFieldEnum: {
    type: 'type',
    action: 'action',
    id_object: 'id_object',
    id_shop: 'id_shop',
    lang_iso: 'lang_iso',
    created_at: 'created_at'
  };

  export type Ps_eventbus_incremental_syncScalarFieldEnum = (typeof Ps_eventbus_incremental_syncScalarFieldEnum)[keyof typeof Ps_eventbus_incremental_syncScalarFieldEnum]


  export const Ps_eventbus_jobScalarFieldEnum: {
    job_id: 'job_id',
    created_at: 'created_at'
  };

  export type Ps_eventbus_jobScalarFieldEnum = (typeof Ps_eventbus_jobScalarFieldEnum)[keyof typeof Ps_eventbus_jobScalarFieldEnum]


  export const Ps_eventbus_live_syncScalarFieldEnum: {
    shop_content: 'shop_content',
    last_change_at: 'last_change_at'
  };

  export type Ps_eventbus_live_syncScalarFieldEnum = (typeof Ps_eventbus_live_syncScalarFieldEnum)[keyof typeof Ps_eventbus_live_syncScalarFieldEnum]


  export const Ps_eventbus_type_syncScalarFieldEnum: {
    type: 'type',
    offset: 'offset',
    id_shop: 'id_shop',
    lang_iso: 'lang_iso',
    full_sync_finished: 'full_sync_finished',
    last_sync_date: 'last_sync_date'
  };

  export type Ps_eventbus_type_syncScalarFieldEnum = (typeof Ps_eventbus_type_syncScalarFieldEnum)[keyof typeof Ps_eventbus_type_syncScalarFieldEnum]


  export const SortOrder: {
    asc: 'asc',
    desc: 'desc'
  };

  export type SortOrder = (typeof SortOrder)[keyof typeof SortOrder]


  export const NullsOrder: {
    first: 'first',
    last: 'last'
  };

  export type NullsOrder = (typeof NullsOrder)[keyof typeof NullsOrder]


  export const ps_configurationOrderByRelevanceFieldEnum: {
    name: 'name',
    value: 'value'
  };

  export type ps_configurationOrderByRelevanceFieldEnum = (typeof ps_configurationOrderByRelevanceFieldEnum)[keyof typeof ps_configurationOrderByRelevanceFieldEnum]


  export const ps_eventbus_incremental_syncOrderByRelevanceFieldEnum: {
    type: 'type',
    action: 'action',
    id_object: 'id_object',
    lang_iso: 'lang_iso'
  };

  export type ps_eventbus_incremental_syncOrderByRelevanceFieldEnum = (typeof ps_eventbus_incremental_syncOrderByRelevanceFieldEnum)[keyof typeof ps_eventbus_incremental_syncOrderByRelevanceFieldEnum]


  export const ps_eventbus_jobOrderByRelevanceFieldEnum: {
    job_id: 'job_id'
  };

  export type ps_eventbus_jobOrderByRelevanceFieldEnum = (typeof ps_eventbus_jobOrderByRelevanceFieldEnum)[keyof typeof ps_eventbus_jobOrderByRelevanceFieldEnum]


  export const ps_eventbus_live_syncOrderByRelevanceFieldEnum: {
    shop_content: 'shop_content'
  };

  export type ps_eventbus_live_syncOrderByRelevanceFieldEnum = (typeof ps_eventbus_live_syncOrderByRelevanceFieldEnum)[keyof typeof ps_eventbus_live_syncOrderByRelevanceFieldEnum]


  export const ps_eventbus_type_syncOrderByRelevanceFieldEnum: {
    type: 'type',
    lang_iso: 'lang_iso'
  };

  export type ps_eventbus_type_syncOrderByRelevanceFieldEnum = (typeof ps_eventbus_type_syncOrderByRelevanceFieldEnum)[keyof typeof ps_eventbus_type_syncOrderByRelevanceFieldEnum]


  /**
   * Field references
   */


  /**
   * Reference to a field of type 'Int'
   */
  export type IntFieldRefInput<$PrismaModel> = FieldRefInputType<$PrismaModel, 'Int'>
    


  /**
   * Reference to a field of type 'String'
   */
  export type StringFieldRefInput<$PrismaModel> = FieldRefInputType<$PrismaModel, 'String'>
    


  /**
   * Reference to a field of type 'DateTime'
   */
  export type DateTimeFieldRefInput<$PrismaModel> = FieldRefInputType<$PrismaModel, 'DateTime'>
    


  /**
   * Reference to a field of type 'Boolean'
   */
  export type BooleanFieldRefInput<$PrismaModel> = FieldRefInputType<$PrismaModel, 'Boolean'>
    


  /**
   * Reference to a field of type 'Float'
   */
  export type FloatFieldRefInput<$PrismaModel> = FieldRefInputType<$PrismaModel, 'Float'>
    
  /**
   * Deep Input Types
   */


  export type ps_configurationWhereInput = {
    AND?: ps_configurationWhereInput | ps_configurationWhereInput[]
    OR?: ps_configurationWhereInput[]
    NOT?: ps_configurationWhereInput | ps_configurationWhereInput[]
    id_configuration?: IntFilter<"ps_configuration"> | number
    id_shop_group?: IntNullableFilter<"ps_configuration"> | number | null
    id_shop?: IntNullableFilter<"ps_configuration"> | number | null
    name?: StringFilter<"ps_configuration"> | string
    value?: StringNullableFilter<"ps_configuration"> | string | null
    date_add?: DateTimeFilter<"ps_configuration"> | Date | string
    date_upd?: DateTimeFilter<"ps_configuration"> | Date | string
  }

  export type ps_configurationOrderByWithRelationInput = {
    id_configuration?: SortOrder
    id_shop_group?: SortOrderInput | SortOrder
    id_shop?: SortOrderInput | SortOrder
    name?: SortOrder
    value?: SortOrderInput | SortOrder
    date_add?: SortOrder
    date_upd?: SortOrder
    _relevance?: ps_configurationOrderByRelevanceInput
  }

  export type ps_configurationWhereUniqueInput = Prisma.AtLeast<{
    id_configuration?: number
    AND?: ps_configurationWhereInput | ps_configurationWhereInput[]
    OR?: ps_configurationWhereInput[]
    NOT?: ps_configurationWhereInput | ps_configurationWhereInput[]
    id_shop_group?: IntNullableFilter<"ps_configuration"> | number | null
    id_shop?: IntNullableFilter<"ps_configuration"> | number | null
    name?: StringFilter<"ps_configuration"> | string
    value?: StringNullableFilter<"ps_configuration"> | string | null
    date_add?: DateTimeFilter<"ps_configuration"> | Date | string
    date_upd?: DateTimeFilter<"ps_configuration"> | Date | string
  }, "id_configuration">

  export type ps_configurationOrderByWithAggregationInput = {
    id_configuration?: SortOrder
    id_shop_group?: SortOrderInput | SortOrder
    id_shop?: SortOrderInput | SortOrder
    name?: SortOrder
    value?: SortOrderInput | SortOrder
    date_add?: SortOrder
    date_upd?: SortOrder
    _count?: ps_configurationCountOrderByAggregateInput
    _avg?: ps_configurationAvgOrderByAggregateInput
    _max?: ps_configurationMaxOrderByAggregateInput
    _min?: ps_configurationMinOrderByAggregateInput
    _sum?: ps_configurationSumOrderByAggregateInput
  }

  export type ps_configurationScalarWhereWithAggregatesInput = {
    AND?: ps_configurationScalarWhereWithAggregatesInput | ps_configurationScalarWhereWithAggregatesInput[]
    OR?: ps_configurationScalarWhereWithAggregatesInput[]
    NOT?: ps_configurationScalarWhereWithAggregatesInput | ps_configurationScalarWhereWithAggregatesInput[]
    id_configuration?: IntWithAggregatesFilter<"ps_configuration"> | number
    id_shop_group?: IntNullableWithAggregatesFilter<"ps_configuration"> | number | null
    id_shop?: IntNullableWithAggregatesFilter<"ps_configuration"> | number | null
    name?: StringWithAggregatesFilter<"ps_configuration"> | string
    value?: StringNullableWithAggregatesFilter<"ps_configuration"> | string | null
    date_add?: DateTimeWithAggregatesFilter<"ps_configuration"> | Date | string
    date_upd?: DateTimeWithAggregatesFilter<"ps_configuration"> | Date | string
  }

  export type ps_eventbus_incremental_syncWhereInput = {
    AND?: ps_eventbus_incremental_syncWhereInput | ps_eventbus_incremental_syncWhereInput[]
    OR?: ps_eventbus_incremental_syncWhereInput[]
    NOT?: ps_eventbus_incremental_syncWhereInput | ps_eventbus_incremental_syncWhereInput[]
    type?: StringFilter<"ps_eventbus_incremental_sync"> | string
    action?: StringFilter<"ps_eventbus_incremental_sync"> | string
    id_object?: StringFilter<"ps_eventbus_incremental_sync"> | string
    id_shop?: IntFilter<"ps_eventbus_incremental_sync"> | number
    lang_iso?: StringFilter<"ps_eventbus_incremental_sync"> | string
    created_at?: DateTimeFilter<"ps_eventbus_incremental_sync"> | Date | string
  }

  export type ps_eventbus_incremental_syncOrderByWithRelationInput = {
    type?: SortOrder
    action?: SortOrder
    id_object?: SortOrder
    id_shop?: SortOrder
    lang_iso?: SortOrder
    created_at?: SortOrder
    _relevance?: ps_eventbus_incremental_syncOrderByRelevanceInput
  }

  export type ps_eventbus_incremental_syncWhereUniqueInput = Prisma.AtLeast<{
    type_id_object_id_shop_lang_iso?: ps_eventbus_incremental_syncTypeId_objectId_shopLang_isoCompoundUniqueInput
    AND?: ps_eventbus_incremental_syncWhereInput | ps_eventbus_incremental_syncWhereInput[]
    OR?: ps_eventbus_incremental_syncWhereInput[]
    NOT?: ps_eventbus_incremental_syncWhereInput | ps_eventbus_incremental_syncWhereInput[]
    type?: StringFilter<"ps_eventbus_incremental_sync"> | string
    action?: StringFilter<"ps_eventbus_incremental_sync"> | string
    id_object?: StringFilter<"ps_eventbus_incremental_sync"> | string
    id_shop?: IntFilter<"ps_eventbus_incremental_sync"> | number
    lang_iso?: StringFilter<"ps_eventbus_incremental_sync"> | string
    created_at?: DateTimeFilter<"ps_eventbus_incremental_sync"> | Date | string
  }, "type_id_object_id_shop_lang_iso">

  export type ps_eventbus_incremental_syncOrderByWithAggregationInput = {
    type?: SortOrder
    action?: SortOrder
    id_object?: SortOrder
    id_shop?: SortOrder
    lang_iso?: SortOrder
    created_at?: SortOrder
    _count?: ps_eventbus_incremental_syncCountOrderByAggregateInput
    _avg?: ps_eventbus_incremental_syncAvgOrderByAggregateInput
    _max?: ps_eventbus_incremental_syncMaxOrderByAggregateInput
    _min?: ps_eventbus_incremental_syncMinOrderByAggregateInput
    _sum?: ps_eventbus_incremental_syncSumOrderByAggregateInput
  }

  export type ps_eventbus_incremental_syncScalarWhereWithAggregatesInput = {
    AND?: ps_eventbus_incremental_syncScalarWhereWithAggregatesInput | ps_eventbus_incremental_syncScalarWhereWithAggregatesInput[]
    OR?: ps_eventbus_incremental_syncScalarWhereWithAggregatesInput[]
    NOT?: ps_eventbus_incremental_syncScalarWhereWithAggregatesInput | ps_eventbus_incremental_syncScalarWhereWithAggregatesInput[]
    type?: StringWithAggregatesFilter<"ps_eventbus_incremental_sync"> | string
    action?: StringWithAggregatesFilter<"ps_eventbus_incremental_sync"> | string
    id_object?: StringWithAggregatesFilter<"ps_eventbus_incremental_sync"> | string
    id_shop?: IntWithAggregatesFilter<"ps_eventbus_incremental_sync"> | number
    lang_iso?: StringWithAggregatesFilter<"ps_eventbus_incremental_sync"> | string
    created_at?: DateTimeWithAggregatesFilter<"ps_eventbus_incremental_sync"> | Date | string
  }

  export type ps_eventbus_jobWhereInput = {
    AND?: ps_eventbus_jobWhereInput | ps_eventbus_jobWhereInput[]
    OR?: ps_eventbus_jobWhereInput[]
    NOT?: ps_eventbus_jobWhereInput | ps_eventbus_jobWhereInput[]
    job_id?: StringFilter<"ps_eventbus_job"> | string
    created_at?: DateTimeFilter<"ps_eventbus_job"> | Date | string
  }

  export type ps_eventbus_jobOrderByWithRelationInput = {
    job_id?: SortOrder
    created_at?: SortOrder
    _relevance?: ps_eventbus_jobOrderByRelevanceInput
  }

  export type ps_eventbus_jobWhereUniqueInput = Prisma.AtLeast<{
    job_id_created_at?: ps_eventbus_jobJob_idCreated_atCompoundUniqueInput
    AND?: ps_eventbus_jobWhereInput | ps_eventbus_jobWhereInput[]
    OR?: ps_eventbus_jobWhereInput[]
    NOT?: ps_eventbus_jobWhereInput | ps_eventbus_jobWhereInput[]
    job_id?: StringFilter<"ps_eventbus_job"> | string
    created_at?: DateTimeFilter<"ps_eventbus_job"> | Date | string
  }, "job_id_created_at">

  export type ps_eventbus_jobOrderByWithAggregationInput = {
    job_id?: SortOrder
    created_at?: SortOrder
    _count?: ps_eventbus_jobCountOrderByAggregateInput
    _max?: ps_eventbus_jobMaxOrderByAggregateInput
    _min?: ps_eventbus_jobMinOrderByAggregateInput
  }

  export type ps_eventbus_jobScalarWhereWithAggregatesInput = {
    AND?: ps_eventbus_jobScalarWhereWithAggregatesInput | ps_eventbus_jobScalarWhereWithAggregatesInput[]
    OR?: ps_eventbus_jobScalarWhereWithAggregatesInput[]
    NOT?: ps_eventbus_jobScalarWhereWithAggregatesInput | ps_eventbus_jobScalarWhereWithAggregatesInput[]
    job_id?: StringWithAggregatesFilter<"ps_eventbus_job"> | string
    created_at?: DateTimeWithAggregatesFilter<"ps_eventbus_job"> | Date | string
  }

  export type ps_eventbus_live_syncWhereInput = {
    AND?: ps_eventbus_live_syncWhereInput | ps_eventbus_live_syncWhereInput[]
    OR?: ps_eventbus_live_syncWhereInput[]
    NOT?: ps_eventbus_live_syncWhereInput | ps_eventbus_live_syncWhereInput[]
    shop_content?: StringFilter<"ps_eventbus_live_sync"> | string
    last_change_at?: DateTimeFilter<"ps_eventbus_live_sync"> | Date | string
  }

  export type ps_eventbus_live_syncOrderByWithRelationInput = {
    shop_content?: SortOrder
    last_change_at?: SortOrder
    _relevance?: ps_eventbus_live_syncOrderByRelevanceInput
  }

  export type ps_eventbus_live_syncWhereUniqueInput = Prisma.AtLeast<{
    shop_content?: string
    AND?: ps_eventbus_live_syncWhereInput | ps_eventbus_live_syncWhereInput[]
    OR?: ps_eventbus_live_syncWhereInput[]
    NOT?: ps_eventbus_live_syncWhereInput | ps_eventbus_live_syncWhereInput[]
    last_change_at?: DateTimeFilter<"ps_eventbus_live_sync"> | Date | string
  }, "shop_content">

  export type ps_eventbus_live_syncOrderByWithAggregationInput = {
    shop_content?: SortOrder
    last_change_at?: SortOrder
    _count?: ps_eventbus_live_syncCountOrderByAggregateInput
    _max?: ps_eventbus_live_syncMaxOrderByAggregateInput
    _min?: ps_eventbus_live_syncMinOrderByAggregateInput
  }

  export type ps_eventbus_live_syncScalarWhereWithAggregatesInput = {
    AND?: ps_eventbus_live_syncScalarWhereWithAggregatesInput | ps_eventbus_live_syncScalarWhereWithAggregatesInput[]
    OR?: ps_eventbus_live_syncScalarWhereWithAggregatesInput[]
    NOT?: ps_eventbus_live_syncScalarWhereWithAggregatesInput | ps_eventbus_live_syncScalarWhereWithAggregatesInput[]
    shop_content?: StringWithAggregatesFilter<"ps_eventbus_live_sync"> | string
    last_change_at?: DateTimeWithAggregatesFilter<"ps_eventbus_live_sync"> | Date | string
  }

  export type ps_eventbus_type_syncWhereInput = {
    AND?: ps_eventbus_type_syncWhereInput | ps_eventbus_type_syncWhereInput[]
    OR?: ps_eventbus_type_syncWhereInput[]
    NOT?: ps_eventbus_type_syncWhereInput | ps_eventbus_type_syncWhereInput[]
    type?: StringFilter<"ps_eventbus_type_sync"> | string
    offset?: IntFilter<"ps_eventbus_type_sync"> | number
    id_shop?: IntFilter<"ps_eventbus_type_sync"> | number
    lang_iso?: StringFilter<"ps_eventbus_type_sync"> | string
    full_sync_finished?: BoolFilter<"ps_eventbus_type_sync"> | boolean
    last_sync_date?: DateTimeFilter<"ps_eventbus_type_sync"> | Date | string
  }

  export type ps_eventbus_type_syncOrderByWithRelationInput = {
    type?: SortOrder
    offset?: SortOrder
    id_shop?: SortOrder
    lang_iso?: SortOrder
    full_sync_finished?: SortOrder
    last_sync_date?: SortOrder
    _relevance?: ps_eventbus_type_syncOrderByRelevanceInput
  }

  export type ps_eventbus_type_syncWhereUniqueInput = Prisma.AtLeast<{
    type_id_shop_lang_iso?: ps_eventbus_type_syncTypeId_shopLang_isoCompoundUniqueInput
    AND?: ps_eventbus_type_syncWhereInput | ps_eventbus_type_syncWhereInput[]
    OR?: ps_eventbus_type_syncWhereInput[]
    NOT?: ps_eventbus_type_syncWhereInput | ps_eventbus_type_syncWhereInput[]
    type?: StringFilter<"ps_eventbus_type_sync"> | string
    offset?: IntFilter<"ps_eventbus_type_sync"> | number
    id_shop?: IntFilter<"ps_eventbus_type_sync"> | number
    lang_iso?: StringFilter<"ps_eventbus_type_sync"> | string
    full_sync_finished?: BoolFilter<"ps_eventbus_type_sync"> | boolean
    last_sync_date?: DateTimeFilter<"ps_eventbus_type_sync"> | Date | string
  }, "type_id_shop_lang_iso">

  export type ps_eventbus_type_syncOrderByWithAggregationInput = {
    type?: SortOrder
    offset?: SortOrder
    id_shop?: SortOrder
    lang_iso?: SortOrder
    full_sync_finished?: SortOrder
    last_sync_date?: SortOrder
    _count?: ps_eventbus_type_syncCountOrderByAggregateInput
    _avg?: ps_eventbus_type_syncAvgOrderByAggregateInput
    _max?: ps_eventbus_type_syncMaxOrderByAggregateInput
    _min?: ps_eventbus_type_syncMinOrderByAggregateInput
    _sum?: ps_eventbus_type_syncSumOrderByAggregateInput
  }

  export type ps_eventbus_type_syncScalarWhereWithAggregatesInput = {
    AND?: ps_eventbus_type_syncScalarWhereWithAggregatesInput | ps_eventbus_type_syncScalarWhereWithAggregatesInput[]
    OR?: ps_eventbus_type_syncScalarWhereWithAggregatesInput[]
    NOT?: ps_eventbus_type_syncScalarWhereWithAggregatesInput | ps_eventbus_type_syncScalarWhereWithAggregatesInput[]
    type?: StringWithAggregatesFilter<"ps_eventbus_type_sync"> | string
    offset?: IntWithAggregatesFilter<"ps_eventbus_type_sync"> | number
    id_shop?: IntWithAggregatesFilter<"ps_eventbus_type_sync"> | number
    lang_iso?: StringWithAggregatesFilter<"ps_eventbus_type_sync"> | string
    full_sync_finished?: BoolWithAggregatesFilter<"ps_eventbus_type_sync"> | boolean
    last_sync_date?: DateTimeWithAggregatesFilter<"ps_eventbus_type_sync"> | Date | string
  }

  export type ps_configurationCreateInput = {
    id_shop_group?: number | null
    id_shop?: number | null
    name: string
    value?: string | null
    date_add: Date | string
    date_upd: Date | string
  }

  export type ps_configurationUncheckedCreateInput = {
    id_configuration?: number
    id_shop_group?: number | null
    id_shop?: number | null
    name: string
    value?: string | null
    date_add: Date | string
    date_upd: Date | string
  }

  export type ps_configurationUpdateInput = {
    id_shop_group?: NullableIntFieldUpdateOperationsInput | number | null
    id_shop?: NullableIntFieldUpdateOperationsInput | number | null
    name?: StringFieldUpdateOperationsInput | string
    value?: NullableStringFieldUpdateOperationsInput | string | null
    date_add?: DateTimeFieldUpdateOperationsInput | Date | string
    date_upd?: DateTimeFieldUpdateOperationsInput | Date | string
  }

  export type ps_configurationUncheckedUpdateInput = {
    id_configuration?: IntFieldUpdateOperationsInput | number
    id_shop_group?: NullableIntFieldUpdateOperationsInput | number | null
    id_shop?: NullableIntFieldUpdateOperationsInput | number | null
    name?: StringFieldUpdateOperationsInput | string
    value?: NullableStringFieldUpdateOperationsInput | string | null
    date_add?: DateTimeFieldUpdateOperationsInput | Date | string
    date_upd?: DateTimeFieldUpdateOperationsInput | Date | string
  }

  export type ps_configurationCreateManyInput = {
    id_configuration?: number
    id_shop_group?: number | null
    id_shop?: number | null
    name: string
    value?: string | null
    date_add: Date | string
    date_upd: Date | string
  }

  export type ps_configurationUpdateManyMutationInput = {
    id_shop_group?: NullableIntFieldUpdateOperationsInput | number | null
    id_shop?: NullableIntFieldUpdateOperationsInput | number | null
    name?: StringFieldUpdateOperationsInput | string
    value?: NullableStringFieldUpdateOperationsInput | string | null
    date_add?: DateTimeFieldUpdateOperationsInput | Date | string
    date_upd?: DateTimeFieldUpdateOperationsInput | Date | string
  }

  export type ps_configurationUncheckedUpdateManyInput = {
    id_configuration?: IntFieldUpdateOperationsInput | number
    id_shop_group?: NullableIntFieldUpdateOperationsInput | number | null
    id_shop?: NullableIntFieldUpdateOperationsInput | number | null
    name?: StringFieldUpdateOperationsInput | string
    value?: NullableStringFieldUpdateOperationsInput | string | null
    date_add?: DateTimeFieldUpdateOperationsInput | Date | string
    date_upd?: DateTimeFieldUpdateOperationsInput | Date | string
  }

  export type ps_eventbus_incremental_syncCreateInput = {
    type: string
    action?: string
    id_object: string
    id_shop: number
    lang_iso: string
    created_at: Date | string
  }

  export type ps_eventbus_incremental_syncUncheckedCreateInput = {
    type: string
    action?: string
    id_object: string
    id_shop: number
    lang_iso: string
    created_at: Date | string
  }

  export type ps_eventbus_incremental_syncUpdateInput = {
    type?: StringFieldUpdateOperationsInput | string
    action?: StringFieldUpdateOperationsInput | string
    id_object?: StringFieldUpdateOperationsInput | string
    id_shop?: IntFieldUpdateOperationsInput | number
    lang_iso?: StringFieldUpdateOperationsInput | string
    created_at?: DateTimeFieldUpdateOperationsInput | Date | string
  }

  export type ps_eventbus_incremental_syncUncheckedUpdateInput = {
    type?: StringFieldUpdateOperationsInput | string
    action?: StringFieldUpdateOperationsInput | string
    id_object?: StringFieldUpdateOperationsInput | string
    id_shop?: IntFieldUpdateOperationsInput | number
    lang_iso?: StringFieldUpdateOperationsInput | string
    created_at?: DateTimeFieldUpdateOperationsInput | Date | string
  }

  export type ps_eventbus_incremental_syncCreateManyInput = {
    type: string
    action?: string
    id_object: string
    id_shop: number
    lang_iso: string
    created_at: Date | string
  }

  export type ps_eventbus_incremental_syncUpdateManyMutationInput = {
    type?: StringFieldUpdateOperationsInput | string
    action?: StringFieldUpdateOperationsInput | string
    id_object?: StringFieldUpdateOperationsInput | string
    id_shop?: IntFieldUpdateOperationsInput | number
    lang_iso?: StringFieldUpdateOperationsInput | string
    created_at?: DateTimeFieldUpdateOperationsInput | Date | string
  }

  export type ps_eventbus_incremental_syncUncheckedUpdateManyInput = {
    type?: StringFieldUpdateOperationsInput | string
    action?: StringFieldUpdateOperationsInput | string
    id_object?: StringFieldUpdateOperationsInput | string
    id_shop?: IntFieldUpdateOperationsInput | number
    lang_iso?: StringFieldUpdateOperationsInput | string
    created_at?: DateTimeFieldUpdateOperationsInput | Date | string
  }

  export type ps_eventbus_jobCreateInput = {
    job_id: string
    created_at: Date | string
  }

  export type ps_eventbus_jobUncheckedCreateInput = {
    job_id: string
    created_at: Date | string
  }

  export type ps_eventbus_jobUpdateInput = {
    job_id?: StringFieldUpdateOperationsInput | string
    created_at?: DateTimeFieldUpdateOperationsInput | Date | string
  }

  export type ps_eventbus_jobUncheckedUpdateInput = {
    job_id?: StringFieldUpdateOperationsInput | string
    created_at?: DateTimeFieldUpdateOperationsInput | Date | string
  }

  export type ps_eventbus_jobCreateManyInput = {
    job_id: string
    created_at: Date | string
  }

  export type ps_eventbus_jobUpdateManyMutationInput = {
    job_id?: StringFieldUpdateOperationsInput | string
    created_at?: DateTimeFieldUpdateOperationsInput | Date | string
  }

  export type ps_eventbus_jobUncheckedUpdateManyInput = {
    job_id?: StringFieldUpdateOperationsInput | string
    created_at?: DateTimeFieldUpdateOperationsInput | Date | string
  }

  export type ps_eventbus_live_syncCreateInput = {
    shop_content: string
    last_change_at: Date | string
  }

  export type ps_eventbus_live_syncUncheckedCreateInput = {
    shop_content: string
    last_change_at: Date | string
  }

  export type ps_eventbus_live_syncUpdateInput = {
    shop_content?: StringFieldUpdateOperationsInput | string
    last_change_at?: DateTimeFieldUpdateOperationsInput | Date | string
  }

  export type ps_eventbus_live_syncUncheckedUpdateInput = {
    shop_content?: StringFieldUpdateOperationsInput | string
    last_change_at?: DateTimeFieldUpdateOperationsInput | Date | string
  }

  export type ps_eventbus_live_syncCreateManyInput = {
    shop_content: string
    last_change_at: Date | string
  }

  export type ps_eventbus_live_syncUpdateManyMutationInput = {
    shop_content?: StringFieldUpdateOperationsInput | string
    last_change_at?: DateTimeFieldUpdateOperationsInput | Date | string
  }

  export type ps_eventbus_live_syncUncheckedUpdateManyInput = {
    shop_content?: StringFieldUpdateOperationsInput | string
    last_change_at?: DateTimeFieldUpdateOperationsInput | Date | string
  }

  export type ps_eventbus_type_syncCreateInput = {
    type: string
    offset?: number
    id_shop: number
    lang_iso: string
    full_sync_finished?: boolean
    last_sync_date: Date | string
  }

  export type ps_eventbus_type_syncUncheckedCreateInput = {
    type: string
    offset?: number
    id_shop: number
    lang_iso: string
    full_sync_finished?: boolean
    last_sync_date: Date | string
  }

  export type ps_eventbus_type_syncUpdateInput = {
    type?: StringFieldUpdateOperationsInput | string
    offset?: IntFieldUpdateOperationsInput | number
    id_shop?: IntFieldUpdateOperationsInput | number
    lang_iso?: StringFieldUpdateOperationsInput | string
    full_sync_finished?: BoolFieldUpdateOperationsInput | boolean
    last_sync_date?: DateTimeFieldUpdateOperationsInput | Date | string
  }

  export type ps_eventbus_type_syncUncheckedUpdateInput = {
    type?: StringFieldUpdateOperationsInput | string
    offset?: IntFieldUpdateOperationsInput | number
    id_shop?: IntFieldUpdateOperationsInput | number
    lang_iso?: StringFieldUpdateOperationsInput | string
    full_sync_finished?: BoolFieldUpdateOperationsInput | boolean
    last_sync_date?: DateTimeFieldUpdateOperationsInput | Date | string
  }

  export type ps_eventbus_type_syncCreateManyInput = {
    type: string
    offset?: number
    id_shop: number
    lang_iso: string
    full_sync_finished?: boolean
    last_sync_date: Date | string
  }

  export type ps_eventbus_type_syncUpdateManyMutationInput = {
    type?: StringFieldUpdateOperationsInput | string
    offset?: IntFieldUpdateOperationsInput | number
    id_shop?: IntFieldUpdateOperationsInput | number
    lang_iso?: StringFieldUpdateOperationsInput | string
    full_sync_finished?: BoolFieldUpdateOperationsInput | boolean
    last_sync_date?: DateTimeFieldUpdateOperationsInput | Date | string
  }

  export type ps_eventbus_type_syncUncheckedUpdateManyInput = {
    type?: StringFieldUpdateOperationsInput | string
    offset?: IntFieldUpdateOperationsInput | number
    id_shop?: IntFieldUpdateOperationsInput | number
    lang_iso?: StringFieldUpdateOperationsInput | string
    full_sync_finished?: BoolFieldUpdateOperationsInput | boolean
    last_sync_date?: DateTimeFieldUpdateOperationsInput | Date | string
  }

  export type IntFilter<$PrismaModel = never> = {
    equals?: number | IntFieldRefInput<$PrismaModel>
    in?: number[]
    notIn?: number[]
    lt?: number | IntFieldRefInput<$PrismaModel>
    lte?: number | IntFieldRefInput<$PrismaModel>
    gt?: number | IntFieldRefInput<$PrismaModel>
    gte?: number | IntFieldRefInput<$PrismaModel>
    not?: NestedIntFilter<$PrismaModel> | number
  }

  export type IntNullableFilter<$PrismaModel = never> = {
    equals?: number | IntFieldRefInput<$PrismaModel> | null
    in?: number[] | null
    notIn?: number[] | null
    lt?: number | IntFieldRefInput<$PrismaModel>
    lte?: number | IntFieldRefInput<$PrismaModel>
    gt?: number | IntFieldRefInput<$PrismaModel>
    gte?: number | IntFieldRefInput<$PrismaModel>
    not?: NestedIntNullableFilter<$PrismaModel> | number | null
  }

  export type StringFilter<$PrismaModel = never> = {
    equals?: string | StringFieldRefInput<$PrismaModel>
    in?: string[]
    notIn?: string[]
    lt?: string | StringFieldRefInput<$PrismaModel>
    lte?: string | StringFieldRefInput<$PrismaModel>
    gt?: string | StringFieldRefInput<$PrismaModel>
    gte?: string | StringFieldRefInput<$PrismaModel>
    contains?: string | StringFieldRefInput<$PrismaModel>
    startsWith?: string | StringFieldRefInput<$PrismaModel>
    endsWith?: string | StringFieldRefInput<$PrismaModel>
    search?: string
    not?: NestedStringFilter<$PrismaModel> | string
  }

  export type StringNullableFilter<$PrismaModel = never> = {
    equals?: string | StringFieldRefInput<$PrismaModel> | null
    in?: string[] | null
    notIn?: string[] | null
    lt?: string | StringFieldRefInput<$PrismaModel>
    lte?: string | StringFieldRefInput<$PrismaModel>
    gt?: string | StringFieldRefInput<$PrismaModel>
    gte?: string | StringFieldRefInput<$PrismaModel>
    contains?: string | StringFieldRefInput<$PrismaModel>
    startsWith?: string | StringFieldRefInput<$PrismaModel>
    endsWith?: string | StringFieldRefInput<$PrismaModel>
    search?: string
    not?: NestedStringNullableFilter<$PrismaModel> | string | null
  }

  export type DateTimeFilter<$PrismaModel = never> = {
    equals?: Date | string | DateTimeFieldRefInput<$PrismaModel>
    in?: Date[] | string[]
    notIn?: Date[] | string[]
    lt?: Date | string | DateTimeFieldRefInput<$PrismaModel>
    lte?: Date | string | DateTimeFieldRefInput<$PrismaModel>
    gt?: Date | string | DateTimeFieldRefInput<$PrismaModel>
    gte?: Date | string | DateTimeFieldRefInput<$PrismaModel>
    not?: NestedDateTimeFilter<$PrismaModel> | Date | string
  }

  export type SortOrderInput = {
    sort: SortOrder
    nulls?: NullsOrder
  }

  export type ps_configurationOrderByRelevanceInput = {
    fields: ps_configurationOrderByRelevanceFieldEnum | ps_configurationOrderByRelevanceFieldEnum[]
    sort: SortOrder
    search: string
  }

  export type ps_configurationCountOrderByAggregateInput = {
    id_configuration?: SortOrder
    id_shop_group?: SortOrder
    id_shop?: SortOrder
    name?: SortOrder
    value?: SortOrder
    date_add?: SortOrder
    date_upd?: SortOrder
  }

  export type ps_configurationAvgOrderByAggregateInput = {
    id_configuration?: SortOrder
    id_shop_group?: SortOrder
    id_shop?: SortOrder
  }

  export type ps_configurationMaxOrderByAggregateInput = {
    id_configuration?: SortOrder
    id_shop_group?: SortOrder
    id_shop?: SortOrder
    name?: SortOrder
    value?: SortOrder
    date_add?: SortOrder
    date_upd?: SortOrder
  }

  export type ps_configurationMinOrderByAggregateInput = {
    id_configuration?: SortOrder
    id_shop_group?: SortOrder
    id_shop?: SortOrder
    name?: SortOrder
    value?: SortOrder
    date_add?: SortOrder
    date_upd?: SortOrder
  }

  export type ps_configurationSumOrderByAggregateInput = {
    id_configuration?: SortOrder
    id_shop_group?: SortOrder
    id_shop?: SortOrder
  }

  export type IntWithAggregatesFilter<$PrismaModel = never> = {
    equals?: number | IntFieldRefInput<$PrismaModel>
    in?: number[]
    notIn?: number[]
    lt?: number | IntFieldRefInput<$PrismaModel>
    lte?: number | IntFieldRefInput<$PrismaModel>
    gt?: number | IntFieldRefInput<$PrismaModel>
    gte?: number | IntFieldRefInput<$PrismaModel>
    not?: NestedIntWithAggregatesFilter<$PrismaModel> | number
    _count?: NestedIntFilter<$PrismaModel>
    _avg?: NestedFloatFilter<$PrismaModel>
    _sum?: NestedIntFilter<$PrismaModel>
    _min?: NestedIntFilter<$PrismaModel>
    _max?: NestedIntFilter<$PrismaModel>
  }

  export type IntNullableWithAggregatesFilter<$PrismaModel = never> = {
    equals?: number | IntFieldRefInput<$PrismaModel> | null
    in?: number[] | null
    notIn?: number[] | null
    lt?: number | IntFieldRefInput<$PrismaModel>
    lte?: number | IntFieldRefInput<$PrismaModel>
    gt?: number | IntFieldRefInput<$PrismaModel>
    gte?: number | IntFieldRefInput<$PrismaModel>
    not?: NestedIntNullableWithAggregatesFilter<$PrismaModel> | number | null
    _count?: NestedIntNullableFilter<$PrismaModel>
    _avg?: NestedFloatNullableFilter<$PrismaModel>
    _sum?: NestedIntNullableFilter<$PrismaModel>
    _min?: NestedIntNullableFilter<$PrismaModel>
    _max?: NestedIntNullableFilter<$PrismaModel>
  }

  export type StringWithAggregatesFilter<$PrismaModel = never> = {
    equals?: string | StringFieldRefInput<$PrismaModel>
    in?: string[]
    notIn?: string[]
    lt?: string | StringFieldRefInput<$PrismaModel>
    lte?: string | StringFieldRefInput<$PrismaModel>
    gt?: string | StringFieldRefInput<$PrismaModel>
    gte?: string | StringFieldRefInput<$PrismaModel>
    contains?: string | StringFieldRefInput<$PrismaModel>
    startsWith?: string | StringFieldRefInput<$PrismaModel>
    endsWith?: string | StringFieldRefInput<$PrismaModel>
    search?: string
    not?: NestedStringWithAggregatesFilter<$PrismaModel> | string
    _count?: NestedIntFilter<$PrismaModel>
    _min?: NestedStringFilter<$PrismaModel>
    _max?: NestedStringFilter<$PrismaModel>
  }

  export type StringNullableWithAggregatesFilter<$PrismaModel = never> = {
    equals?: string | StringFieldRefInput<$PrismaModel> | null
    in?: string[] | null
    notIn?: string[] | null
    lt?: string | StringFieldRefInput<$PrismaModel>
    lte?: string | StringFieldRefInput<$PrismaModel>
    gt?: string | StringFieldRefInput<$PrismaModel>
    gte?: string | StringFieldRefInput<$PrismaModel>
    contains?: string | StringFieldRefInput<$PrismaModel>
    startsWith?: string | StringFieldRefInput<$PrismaModel>
    endsWith?: string | StringFieldRefInput<$PrismaModel>
    search?: string
    not?: NestedStringNullableWithAggregatesFilter<$PrismaModel> | string | null
    _count?: NestedIntNullableFilter<$PrismaModel>
    _min?: NestedStringNullableFilter<$PrismaModel>
    _max?: NestedStringNullableFilter<$PrismaModel>
  }

  export type DateTimeWithAggregatesFilter<$PrismaModel = never> = {
    equals?: Date | string | DateTimeFieldRefInput<$PrismaModel>
    in?: Date[] | string[]
    notIn?: Date[] | string[]
    lt?: Date | string | DateTimeFieldRefInput<$PrismaModel>
    lte?: Date | string | DateTimeFieldRefInput<$PrismaModel>
    gt?: Date | string | DateTimeFieldRefInput<$PrismaModel>
    gte?: Date | string | DateTimeFieldRefInput<$PrismaModel>
    not?: NestedDateTimeWithAggregatesFilter<$PrismaModel> | Date | string
    _count?: NestedIntFilter<$PrismaModel>
    _min?: NestedDateTimeFilter<$PrismaModel>
    _max?: NestedDateTimeFilter<$PrismaModel>
  }

  export type ps_eventbus_incremental_syncOrderByRelevanceInput = {
    fields: ps_eventbus_incremental_syncOrderByRelevanceFieldEnum | ps_eventbus_incremental_syncOrderByRelevanceFieldEnum[]
    sort: SortOrder
    search: string
  }

  export type ps_eventbus_incremental_syncTypeId_objectId_shopLang_isoCompoundUniqueInput = {
    type: string
    id_object: string
    id_shop: number
    lang_iso: string
  }

  export type ps_eventbus_incremental_syncCountOrderByAggregateInput = {
    type?: SortOrder
    action?: SortOrder
    id_object?: SortOrder
    id_shop?: SortOrder
    lang_iso?: SortOrder
    created_at?: SortOrder
  }

  export type ps_eventbus_incremental_syncAvgOrderByAggregateInput = {
    id_shop?: SortOrder
  }

  export type ps_eventbus_incremental_syncMaxOrderByAggregateInput = {
    type?: SortOrder
    action?: SortOrder
    id_object?: SortOrder
    id_shop?: SortOrder
    lang_iso?: SortOrder
    created_at?: SortOrder
  }

  export type ps_eventbus_incremental_syncMinOrderByAggregateInput = {
    type?: SortOrder
    action?: SortOrder
    id_object?: SortOrder
    id_shop?: SortOrder
    lang_iso?: SortOrder
    created_at?: SortOrder
  }

  export type ps_eventbus_incremental_syncSumOrderByAggregateInput = {
    id_shop?: SortOrder
  }

  export type ps_eventbus_jobOrderByRelevanceInput = {
    fields: ps_eventbus_jobOrderByRelevanceFieldEnum | ps_eventbus_jobOrderByRelevanceFieldEnum[]
    sort: SortOrder
    search: string
  }

  export type ps_eventbus_jobJob_idCreated_atCompoundUniqueInput = {
    job_id: string
    created_at: Date | string
  }

  export type ps_eventbus_jobCountOrderByAggregateInput = {
    job_id?: SortOrder
    created_at?: SortOrder
  }

  export type ps_eventbus_jobMaxOrderByAggregateInput = {
    job_id?: SortOrder
    created_at?: SortOrder
  }

  export type ps_eventbus_jobMinOrderByAggregateInput = {
    job_id?: SortOrder
    created_at?: SortOrder
  }

  export type ps_eventbus_live_syncOrderByRelevanceInput = {
    fields: ps_eventbus_live_syncOrderByRelevanceFieldEnum | ps_eventbus_live_syncOrderByRelevanceFieldEnum[]
    sort: SortOrder
    search: string
  }

  export type ps_eventbus_live_syncCountOrderByAggregateInput = {
    shop_content?: SortOrder
    last_change_at?: SortOrder
  }

  export type ps_eventbus_live_syncMaxOrderByAggregateInput = {
    shop_content?: SortOrder
    last_change_at?: SortOrder
  }

  export type ps_eventbus_live_syncMinOrderByAggregateInput = {
    shop_content?: SortOrder
    last_change_at?: SortOrder
  }

  export type BoolFilter<$PrismaModel = never> = {
    equals?: boolean | BooleanFieldRefInput<$PrismaModel>
    not?: NestedBoolFilter<$PrismaModel> | boolean
  }

  export type ps_eventbus_type_syncOrderByRelevanceInput = {
    fields: ps_eventbus_type_syncOrderByRelevanceFieldEnum | ps_eventbus_type_syncOrderByRelevanceFieldEnum[]
    sort: SortOrder
    search: string
  }

  export type ps_eventbus_type_syncTypeId_shopLang_isoCompoundUniqueInput = {
    type: string
    id_shop: number
    lang_iso: string
  }

  export type ps_eventbus_type_syncCountOrderByAggregateInput = {
    type?: SortOrder
    offset?: SortOrder
    id_shop?: SortOrder
    lang_iso?: SortOrder
    full_sync_finished?: SortOrder
    last_sync_date?: SortOrder
  }

  export type ps_eventbus_type_syncAvgOrderByAggregateInput = {
    offset?: SortOrder
    id_shop?: SortOrder
  }

  export type ps_eventbus_type_syncMaxOrderByAggregateInput = {
    type?: SortOrder
    offset?: SortOrder
    id_shop?: SortOrder
    lang_iso?: SortOrder
    full_sync_finished?: SortOrder
    last_sync_date?: SortOrder
  }

  export type ps_eventbus_type_syncMinOrderByAggregateInput = {
    type?: SortOrder
    offset?: SortOrder
    id_shop?: SortOrder
    lang_iso?: SortOrder
    full_sync_finished?: SortOrder
    last_sync_date?: SortOrder
  }

  export type ps_eventbus_type_syncSumOrderByAggregateInput = {
    offset?: SortOrder
    id_shop?: SortOrder
  }

  export type BoolWithAggregatesFilter<$PrismaModel = never> = {
    equals?: boolean | BooleanFieldRefInput<$PrismaModel>
    not?: NestedBoolWithAggregatesFilter<$PrismaModel> | boolean
    _count?: NestedIntFilter<$PrismaModel>
    _min?: NestedBoolFilter<$PrismaModel>
    _max?: NestedBoolFilter<$PrismaModel>
  }

  export type NullableIntFieldUpdateOperationsInput = {
    set?: number | null
    increment?: number
    decrement?: number
    multiply?: number
    divide?: number
  }

  export type StringFieldUpdateOperationsInput = {
    set?: string
  }

  export type NullableStringFieldUpdateOperationsInput = {
    set?: string | null
  }

  export type DateTimeFieldUpdateOperationsInput = {
    set?: Date | string
  }

  export type IntFieldUpdateOperationsInput = {
    set?: number
    increment?: number
    decrement?: number
    multiply?: number
    divide?: number
  }

  export type BoolFieldUpdateOperationsInput = {
    set?: boolean
  }

  export type NestedIntFilter<$PrismaModel = never> = {
    equals?: number | IntFieldRefInput<$PrismaModel>
    in?: number[]
    notIn?: number[]
    lt?: number | IntFieldRefInput<$PrismaModel>
    lte?: number | IntFieldRefInput<$PrismaModel>
    gt?: number | IntFieldRefInput<$PrismaModel>
    gte?: number | IntFieldRefInput<$PrismaModel>
    not?: NestedIntFilter<$PrismaModel> | number
  }

  export type NestedIntNullableFilter<$PrismaModel = never> = {
    equals?: number | IntFieldRefInput<$PrismaModel> | null
    in?: number[] | null
    notIn?: number[] | null
    lt?: number | IntFieldRefInput<$PrismaModel>
    lte?: number | IntFieldRefInput<$PrismaModel>
    gt?: number | IntFieldRefInput<$PrismaModel>
    gte?: number | IntFieldRefInput<$PrismaModel>
    not?: NestedIntNullableFilter<$PrismaModel> | number | null
  }

  export type NestedStringFilter<$PrismaModel = never> = {
    equals?: string | StringFieldRefInput<$PrismaModel>
    in?: string[]
    notIn?: string[]
    lt?: string | StringFieldRefInput<$PrismaModel>
    lte?: string | StringFieldRefInput<$PrismaModel>
    gt?: string | StringFieldRefInput<$PrismaModel>
    gte?: string | StringFieldRefInput<$PrismaModel>
    contains?: string | StringFieldRefInput<$PrismaModel>
    startsWith?: string | StringFieldRefInput<$PrismaModel>
    endsWith?: string | StringFieldRefInput<$PrismaModel>
    search?: string
    not?: NestedStringFilter<$PrismaModel> | string
  }

  export type NestedStringNullableFilter<$PrismaModel = never> = {
    equals?: string | StringFieldRefInput<$PrismaModel> | null
    in?: string[] | null
    notIn?: string[] | null
    lt?: string | StringFieldRefInput<$PrismaModel>
    lte?: string | StringFieldRefInput<$PrismaModel>
    gt?: string | StringFieldRefInput<$PrismaModel>
    gte?: string | StringFieldRefInput<$PrismaModel>
    contains?: string | StringFieldRefInput<$PrismaModel>
    startsWith?: string | StringFieldRefInput<$PrismaModel>
    endsWith?: string | StringFieldRefInput<$PrismaModel>
    search?: string
    not?: NestedStringNullableFilter<$PrismaModel> | string | null
  }

  export type NestedDateTimeFilter<$PrismaModel = never> = {
    equals?: Date | string | DateTimeFieldRefInput<$PrismaModel>
    in?: Date[] | string[]
    notIn?: Date[] | string[]
    lt?: Date | string | DateTimeFieldRefInput<$PrismaModel>
    lte?: Date | string | DateTimeFieldRefInput<$PrismaModel>
    gt?: Date | string | DateTimeFieldRefInput<$PrismaModel>
    gte?: Date | string | DateTimeFieldRefInput<$PrismaModel>
    not?: NestedDateTimeFilter<$PrismaModel> | Date | string
  }

  export type NestedIntWithAggregatesFilter<$PrismaModel = never> = {
    equals?: number | IntFieldRefInput<$PrismaModel>
    in?: number[]
    notIn?: number[]
    lt?: number | IntFieldRefInput<$PrismaModel>
    lte?: number | IntFieldRefInput<$PrismaModel>
    gt?: number | IntFieldRefInput<$PrismaModel>
    gte?: number | IntFieldRefInput<$PrismaModel>
    not?: NestedIntWithAggregatesFilter<$PrismaModel> | number
    _count?: NestedIntFilter<$PrismaModel>
    _avg?: NestedFloatFilter<$PrismaModel>
    _sum?: NestedIntFilter<$PrismaModel>
    _min?: NestedIntFilter<$PrismaModel>
    _max?: NestedIntFilter<$PrismaModel>
  }

  export type NestedFloatFilter<$PrismaModel = never> = {
    equals?: number | FloatFieldRefInput<$PrismaModel>
    in?: number[]
    notIn?: number[]
    lt?: number | FloatFieldRefInput<$PrismaModel>
    lte?: number | FloatFieldRefInput<$PrismaModel>
    gt?: number | FloatFieldRefInput<$PrismaModel>
    gte?: number | FloatFieldRefInput<$PrismaModel>
    not?: NestedFloatFilter<$PrismaModel> | number
  }

  export type NestedIntNullableWithAggregatesFilter<$PrismaModel = never> = {
    equals?: number | IntFieldRefInput<$PrismaModel> | null
    in?: number[] | null
    notIn?: number[] | null
    lt?: number | IntFieldRefInput<$PrismaModel>
    lte?: number | IntFieldRefInput<$PrismaModel>
    gt?: number | IntFieldRefInput<$PrismaModel>
    gte?: number | IntFieldRefInput<$PrismaModel>
    not?: NestedIntNullableWithAggregatesFilter<$PrismaModel> | number | null
    _count?: NestedIntNullableFilter<$PrismaModel>
    _avg?: NestedFloatNullableFilter<$PrismaModel>
    _sum?: NestedIntNullableFilter<$PrismaModel>
    _min?: NestedIntNullableFilter<$PrismaModel>
    _max?: NestedIntNullableFilter<$PrismaModel>
  }

  export type NestedFloatNullableFilter<$PrismaModel = never> = {
    equals?: number | FloatFieldRefInput<$PrismaModel> | null
    in?: number[] | null
    notIn?: number[] | null
    lt?: number | FloatFieldRefInput<$PrismaModel>
    lte?: number | FloatFieldRefInput<$PrismaModel>
    gt?: number | FloatFieldRefInput<$PrismaModel>
    gte?: number | FloatFieldRefInput<$PrismaModel>
    not?: NestedFloatNullableFilter<$PrismaModel> | number | null
  }

  export type NestedStringWithAggregatesFilter<$PrismaModel = never> = {
    equals?: string | StringFieldRefInput<$PrismaModel>
    in?: string[]
    notIn?: string[]
    lt?: string | StringFieldRefInput<$PrismaModel>
    lte?: string | StringFieldRefInput<$PrismaModel>
    gt?: string | StringFieldRefInput<$PrismaModel>
    gte?: string | StringFieldRefInput<$PrismaModel>
    contains?: string | StringFieldRefInput<$PrismaModel>
    startsWith?: string | StringFieldRefInput<$PrismaModel>
    endsWith?: string | StringFieldRefInput<$PrismaModel>
    search?: string
    not?: NestedStringWithAggregatesFilter<$PrismaModel> | string
    _count?: NestedIntFilter<$PrismaModel>
    _min?: NestedStringFilter<$PrismaModel>
    _max?: NestedStringFilter<$PrismaModel>
  }

  export type NestedStringNullableWithAggregatesFilter<$PrismaModel = never> = {
    equals?: string | StringFieldRefInput<$PrismaModel> | null
    in?: string[] | null
    notIn?: string[] | null
    lt?: string | StringFieldRefInput<$PrismaModel>
    lte?: string | StringFieldRefInput<$PrismaModel>
    gt?: string | StringFieldRefInput<$PrismaModel>
    gte?: string | StringFieldRefInput<$PrismaModel>
    contains?: string | StringFieldRefInput<$PrismaModel>
    startsWith?: string | StringFieldRefInput<$PrismaModel>
    endsWith?: string | StringFieldRefInput<$PrismaModel>
    search?: string
    not?: NestedStringNullableWithAggregatesFilter<$PrismaModel> | string | null
    _count?: NestedIntNullableFilter<$PrismaModel>
    _min?: NestedStringNullableFilter<$PrismaModel>
    _max?: NestedStringNullableFilter<$PrismaModel>
  }

  export type NestedDateTimeWithAggregatesFilter<$PrismaModel = never> = {
    equals?: Date | string | DateTimeFieldRefInput<$PrismaModel>
    in?: Date[] | string[]
    notIn?: Date[] | string[]
    lt?: Date | string | DateTimeFieldRefInput<$PrismaModel>
    lte?: Date | string | DateTimeFieldRefInput<$PrismaModel>
    gt?: Date | string | DateTimeFieldRefInput<$PrismaModel>
    gte?: Date | string | DateTimeFieldRefInput<$PrismaModel>
    not?: NestedDateTimeWithAggregatesFilter<$PrismaModel> | Date | string
    _count?: NestedIntFilter<$PrismaModel>
    _min?: NestedDateTimeFilter<$PrismaModel>
    _max?: NestedDateTimeFilter<$PrismaModel>
  }

  export type NestedBoolFilter<$PrismaModel = never> = {
    equals?: boolean | BooleanFieldRefInput<$PrismaModel>
    not?: NestedBoolFilter<$PrismaModel> | boolean
  }

  export type NestedBoolWithAggregatesFilter<$PrismaModel = never> = {
    equals?: boolean | BooleanFieldRefInput<$PrismaModel>
    not?: NestedBoolWithAggregatesFilter<$PrismaModel> | boolean
    _count?: NestedIntFilter<$PrismaModel>
    _min?: NestedBoolFilter<$PrismaModel>
    _max?: NestedBoolFilter<$PrismaModel>
  }



  /**
   * Batch Payload for updateMany & deleteMany & createMany
   */

  export type BatchPayload = {
    count: number
  }

  /**
   * DMMF
   */
  export const dmmf: runtime.BaseDMMF
}